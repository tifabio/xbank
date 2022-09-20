<?php

namespace App\Domain\Services\Account;

use App\Domain\Entities\Account\Account;
use App\Domain\Exceptions\Account\AccountNotFoundException;
use App\Infrastructure\Repositories\AccountRepository;

class AccountService
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function deposit($params)
    {
        $destination = $params->get('destination');
        $amount = $params->get('amount');
        
        $account = $this->accountRepository->getById($destination);
        if(!$account) {
            $account = new Account();
            $account->setAccountId($destination);
            $account->setBalance(0);
        }
        
        $account->setBalance($account->getBalance() + $amount);

        $this->accountRepository->save($account);

        return [
            'destination' => $account->toArray()
        ];
    }

    public function withdraw($params)
    {
        $origin = $params->get('origin');
        $amount = $params->get('amount');

        $account = $this->accountRepository->getById($origin);
        $this->validateAccount($account);

        $account->setBalance($account->getBalance() - $amount);

        $this->accountRepository->save($account);

        return [
            'origin' => $account->toArray()
        ];
    }

    public function transfer($params)
    {
        $origin = $params->get('origin');
        $destination = $params->get('destination');
        $amount = $params->get('amount');

        $originAccount = $this->accountRepository->getById($origin);
        $this->validateAccount($originAccount);

        $destinationAccount = $this->accountRepository->getById($destination);
        $this->validateAccount($destinationAccount);

        $originAccount->setBalance($originAccount->getBalance() - $amount);
        $destinationAccount->setBalance($destinationAccount->getBalance() + $amount);

        $this->accountRepository->save($originAccount);        
        $this->accountRepository->save($destinationAccount);    
        
        return [
            'origin' => $originAccount->toArray(),
            'destination' => $destinationAccount->toArray()
        ];
    }

    public function getBalance($accountId)
    {
        $account = $this->accountRepository->getById($accountId);
        $this->validateAccount($account);
        
        return $account->getBalance();
    } 

    public function reset()
    {
        $this->accountRepository->reset();
    }

    private function validateAccount($account)
    {
        if(!$account) {
            throw new AccountNotFoundException();
        }
    }
}