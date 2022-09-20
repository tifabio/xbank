<?php

namespace App\Domain\Exceptions\Account;

use Exception;
use Illuminate\Http\Response;

class AccountNotFoundException extends Exception
{
    public function render(): Response
    {
        $status = 404;
        $error = 0;

        return response($error, $status);
    }
}