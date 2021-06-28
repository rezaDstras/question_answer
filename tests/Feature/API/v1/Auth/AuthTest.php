<?php

namespace Tests\Feature \API\v1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    //for ignoring data in test in database
    use RefreshDatabase;

    /**
     * Before registration this function should be run because each time database will be refresh in TEST
     */
    public function RegisterRolesAndPermissions()
    {
        //create role by defined default data in config->permission.php
        //if don't exist in database
        if (Role::where('name', config('permission.default_roles')[0])->count() <1){
            foreach (config('permission.default_roles') as $role){
                Role::create([
                    'name' => $role,
                ]);
            }
        }

        //create permission by defined default data in config->permission.php
        //if don't exist in database
        if (Permission::where('name', config('permission.default_permission')[0])->count() <1) {
            foreach (config('permission.default_permission') as $permission) {
                Permission::create([
                    'name' => $permission,
                ]);
            }
        }
    }

    /**
     * Register Test
    */
    public function test_register_should_be_validated()
    {
//         $this->assertTrue(1>0);
        $response = $this->postJson(route('auth.register'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_new_user_can_register()
    {
        //use top function before registration for creating role and permission
        $this->RegisterRolesAndPermissions();
//        $this->withExceptionHandling();
        $response = $this->postJson(route('auth.register'), [
            'name' => "ehsan dastras",
            'email' => "test1@gmail.com",
            'password' => "12345678",
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     *  Login Test
    */

    public function test_login_should_be_validated()
    {
        $response = $this->postJson(route('auth.login'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_can_login_with_true_credentials()
    {

        //first create new user with faker -> UserFactory
        $user=User::factory()->create();
        $response = $this->postJson(route('auth.login') , [
            'email'=>$user->email,
            'password'=>'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
    /**
     * Test logged in user
     */
    public function test_logged_in_user_show_info()
    {
        $user=User::factory()->create();
        //behavior as this created user
        $response=$this->actingAs($user)->get(route('auth.user'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_logged_in_user_can_logout()
    {
        $user=User::factory()->create();
        //behavior as this created user
        $response=$this->actingAs($user)->postJson(route('auth.logout'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
