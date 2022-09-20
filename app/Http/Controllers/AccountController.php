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

    public function getBalance(Request $request)
    {
        return $this->accountService->getBalance($request->get('account_id') ?? 0);
    }

    public function reset()
    {
        $this->accountService->reset();
        return 'OK';
    }
}