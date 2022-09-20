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
}
