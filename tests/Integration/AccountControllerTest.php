<?php

namespace Tests\Integration;

use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    public function testAccountReset()
    {
        $this->post('/reset');

        $this->response->assertStatus(200);
        $this->assertEquals(
            'OK', $this->response->getContent()
        );
    }

    public function testAccountNotFoundException()
    {
        $this->post('/reset');

        $this->get('/balance?account_id=1234');

        $this->response->assertStatus(404);
        $this->assertEquals(
            '0', $this->response->getContent()
        );
    }

    public function testCreateAccount()
    {
        $this->post('/reset');

        $accountId = '100';
        $balance = 10;

        $params = [
            'type' => 'deposit',
            'destination' => $accountId,
            'amount' => $balance 
        ];

        $expected = [
            'destination' => [
                'id' => $accountId,
                'balance' => $balance
            ]
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $this->response->assertStatus(201);
        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }

    public function testDepositValidAccount()
    {
        $this->post('/reset');

        $accountId = '100';
        $balance = 10;

        $params = [
            'type' => 'deposit',
            'destination' => $accountId,
            'amount' => $balance 
        ];

        $expected = [
            'destination' => [
                'id' => $accountId,
                'balance' => $balance * 2
            ]
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $this->json(
            'POST',
            '/event',
            $params
        );

        $this->response->assertStatus(201);
        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }

    public function testGetBalanceValidAccount()
    {
        $this->post('/reset');

        $accountId = '100';
        $balance = 10;

        $params = [
            'type' => 'deposit',
            'destination' => $accountId,
            'amount' => $balance 
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $this->json(
            'POST',
            '/event',
            $params
        );

        $this->get("/balance?account_id={$accountId}");

        $this->response->assertStatus(200);
        $this->assertEquals(
            $balance * 2, $this->response->getContent()
        );
    }

    public function testWithdrawAccountNotFound()
    {
        $this->post('/reset');

        $accountId = '200';
        $balance = 10;

        $params = [
            'type' => 'withdraw',
            'origin' => $accountId,
            'amount' => $balance 
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $this->response->assertStatus(404);
        $this->assertEquals(
            '0', $this->response->getContent()
        );
    }

    public function testWithdrawValidAccount()
    {
        $this->post('/reset');

        $accountId = '100';
        $balance = 20;
        $amount = 5;

        $params = [
            'type' => 'deposit',
            'destination' => $accountId,
            'amount' => $balance 
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $params = [
            'type' => 'withdraw',
            'origin' => $accountId,
            'amount' => $amount 
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $expected = [
            'origin' => [
                'id' => $accountId,
                'balance' => $balance - $amount
            ]
        ];

        $this->response->assertStatus(201);
        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }

    public function testTransferValidAccount()
    {
        $this->post('/reset');

        $originId = '100';
        $destinationId = '300';
        $balance = 20;
        $amount = 15;

        $params = [
            'type' => 'deposit',
            'destination' => $originId,
            'amount' => $balance 
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $params = [
            'type' => 'transfer',
            'origin' => $originId,
            'destination' => $destinationId,
            'amount' => $amount 
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $expected = [
            'origin' => [
                'id' => $originId,
                'balance' => $balance - $amount
            ],
            'destination' => [
                'id' => $destinationId,
                'balance' => $amount
            ]
        ];

        $this->response->assertStatus(201);
        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }

    public function testTransferAccountNotFound()
    {
        $this->post('/reset');

        $originId = '200';
        $destinationId = '300';
        $amount = 15;

        $params = [
            'type' => 'transfer',
            'origin' => $originId,
            'destination' => $destinationId,
            'amount' => $amount 
        ];

        $this->json(
            'POST',
            '/event',
            $params
        );

        $this->response->assertStatus(404);
        $this->assertEquals(
            '0', $this->response->getContent()
        );
    }
}
