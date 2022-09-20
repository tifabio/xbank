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

    public function getBalance($accountId)
    {
        $account = $this->accountRepository->getById($accountId);
        if(!$account) {
            throw new AccountNotFoundException();
        } 
        
        return $account->getBalance();
    } 

    public function reset()
    {
        $this->accountRepository->reset();
    }
}