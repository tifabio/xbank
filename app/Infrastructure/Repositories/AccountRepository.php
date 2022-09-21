<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Account\Account;
use Illuminate\Support\Facades\Storage;
 
class AccountRepository
{
    private $accounts;
    private $key = 'accounts';

    public function __construct()
    {
        $this->accounts = Storage::exists($this->key) ? unserialize(Storage::get($this->key)) : [];
    }

    public function save(Account $account)
    {
        $this->accounts[$account->getAccountId()] = $account;
        Storage::put($this->key, serialize($this->accounts));
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
        Storage::put($this->key, '');
    }
}