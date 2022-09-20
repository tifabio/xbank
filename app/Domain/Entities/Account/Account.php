<?php

namespace App\Domain\Entities\Account;

class Account
{
    private $accountId;
    private $balance;

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function toArray()
    {
        return [
            'id' => $this->getAccountId(),
            'balance' => $this->getBalance(),
        ];
    }
}