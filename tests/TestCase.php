<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public $user, $token;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::first();
        $this->token = 'Bearer ' . $this->user->createToken('api-token')->plainTextToken;
    }
}
