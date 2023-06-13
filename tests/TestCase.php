<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create and authenticate a fake user.
     *
     * @return User
     */
    protected function actingAsUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }
}
