<?php

namespace Tests\Unit;

use App\Domain\Entities\Account\Account;
use Tests\TestCase;

class AccountTest extends TestCase
{
    public function testAccountAttributes()
    {
        $accountId = '100';
        $balance = 10;

        $account = new Account();
        $account->setAccountId($accountId);
        $account->setBalance($balance);

        $this->assertEquals($accountId, $account->getAccountId());
        $this->assertEquals($balance, $account->getBalance());
        $this->assertEquals([
            'id' => $account->getAccountId(),
            'balance' => $account->getBalance()
        ], $account->toArray());
    }
}