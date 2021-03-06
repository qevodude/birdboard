<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    protected function signInAs($user = null)
    {

    	//return $this->actingAs($user ?: factory('App\Models\User')->create());
        $user = $user ?: factory('App\Models\User')->create();

        $this->actingAs($user);

        return $user;

    }
}
