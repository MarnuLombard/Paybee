<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PayBee\Models\Token;
use PayBee\Models\User;
use Tests\TestCase;

class ConnectAccountTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testSavesAndFindsUserByToken()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $token = Token::forUser($user);

        $this->assertInstanceOf(Token::class, $token);

        $user = User::findByToken($token->token);
        $this->assertInstanceOf(User::class, $user);

        $this->assertSame($token->user_id, $user->id);
    }
}
