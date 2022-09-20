<?php

namespace App\Http\Controllers;

use App\Domain\Services\Account\AccountService;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function create($id)
    {
        $this->accountService->create($id);
    }

    public function getAll()
    {
        return $this->accountService->getAll();
    }

    public function reset(): string
    {
        $this->accountService->reset();
        return 'OK';
    }
}