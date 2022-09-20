<?php

namespace App\Domain\Services\Account;

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

    public function getAll()
    {
        return $this->accountRepository->getAll();
    } 

    public function reset()
    {
        $this->accountRepository->reset();
    }
}