<?php

namespace Tests\Unit\Http\Controller\API\v1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    //for ignoring data in test in database
    use RefreshDatabase;

    /**
     * Register Test
    */
    public function test_register_should_be_validated()
    {
//         $this->assertTrue(1>0);
        $response = $this->postJson(route('auth.register'));

        $response->assertStatus(422);
    }

    public function test_new_user_can_register()
    {
//        $this->withExceptionHandling();
        $response = $this->postJson(route('auth.register'), [
            'name' => "ehsan dastras",
            'email' => "test1@gmail.com",
            'password' => "12345678",
        ]);

        $response->assertStatus(201);
    }

    /**
     *  Login Test
    */

    public function test_login_should_be_validated()
    {
        $response = $this->postJson(route('auth.login'));

        $response->assertStatus(422);
    }

    public function test_user_can_login_with_true_credentials()
    {

        //first create new user with faker -> UserFactory
        $user=User::factory()->create();
        $response = $this->postJson(route('auth.login') , [
            'email'=>$user->email,
            'password'=>'password',
        ]);

        $response->assertStatus(200);
    }
    /**
     * Test logged in user
     */
    public function test_logged_in_user_show_info()
    {
        $user=User::factory()->create();
        //behavior as this created user
        $response=$this->actingAs($user)->get(route('auth.user'));

        $response->assertStatus(200);
    }

    public function test_logged_in_user_can_logout()
    {
        $user=User::factory()->create();
        //behavior as this created user
        $response=$this->actingAs($user)->postJson(route('auth.logout'));

        $response->assertStatus(200);
    }
}
