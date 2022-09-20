<?php

namespace App\Domain\Services\Account;

use App\Domain\Exceptions\Account\AccountNotFoundException;
use App\Infrastructure\Repositories\AccountRepository;

class AccountService
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create($id)
    {
        $this->accountRepository->create($id);
    }

    public function getBalance($accountId)
    {
        $account = $this->accountRepository->getById($accountId);
        if($account) {
            return $account;
        } 
        
        throw new AccountNotFoundException();
    } 

    public function reset()
    {
        $this->accountRepository->reset();
    }
}