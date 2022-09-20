<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Support\Facades\Session;

class AccountRepository
{
    private $accounts;
    private $key = 'accounts';

    public function __construct()
    {
        $this->accounts = Session::get($this->key);
    }

    public function create($id)
    {
        $this->accounts[$id] = $id;
        Session::put($this->key, $this->accounts);
    }

    public function getAll()
    {
        return $this->accounts;
    }

    public function reset(): void
    {
        $this->accounts = [];
        Session::forget($this->key);
    }
}