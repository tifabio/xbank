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
}
