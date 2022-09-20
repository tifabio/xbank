<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Account\Account;
use Illuminate\Support\Facades\Session;

class AccountRepository
{
    private $accounts;
    private $key = 'accounts';

    public function __construct()
    {
        $this->accounts = Session::get($this->key);
    }

    public function save(Account $account)
    {
        $this->accounts[$account->getAccountId()] = $account;
        Session::put($this->key, $this->accounts);
    }

    public function getById($accountId)
    {
        if(isset($this->accounts[$accountId])) {
            return $this->accounts[$accountId];
        }

        return false;
    }

    public function reset()
    {
        $this->accounts = [];
        Session::forget($this->key);
    }
}