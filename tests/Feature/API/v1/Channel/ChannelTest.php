<?php

namespace Tests\Feature\API\v1\Channel;

use App\Models\Channel;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{
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
     * Test all channels list should be accessible
    */
    public function test_all_channels_list_should_be_accessible()
    {
        $response=$this->get(route('channel.all'));
        $response->assertStatus(Response::HTTP_OK);
    }
    /**
     * Test create channel should be validated
     */
    public function test_channel_should_be_validated()
    {
        $this->RegisterRolesAndPermissions();
        $user=User::factory()->create();
        //login with sanctum
        Sanctum::actingAs($user);
        //give permission to user by Spatie package method (givePermissionTo)
        // * use default permission which defined in config->permission.php *
        $user->givePermissionTo('channel management');

        $response= $this->postJson(route('channel.create'),[]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    /**
     * Test channel can be created
     */
    public function test_channel_can_be_created()
    {
        $this->RegisterRolesAndPermissions();
        $user=User::factory()->create();
        //login with sanctum
        Sanctum::actingAs($user);
        //give permission to user by Spatie package method (givePermissionTo)
        // * use default permission which defined in config->permission.php *
        $user->givePermissionTo('channel management');

        //define fillable in model
        $response= $this->postJson(route('channel.create'),[
            'name'=>'laravel'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test update channel should be validated
     */
    public function test_channel_update_should_be_validated()
    {

          $this->RegisterRolesAndPermissions();
        $user=User::factory()->create();
        //login with sanctum
        Sanctum::actingAs($user);
        //give permission to user by Spatie package method (givePermissionTo)
        // * use default permission which defined in config->permission.php *
        $user->givePermissionTo('channel management');

        $response = $this->json('PUT',route('channel.update'),[]);

        //response 422 -> entity
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test channel could be updated
     */
    public function test_channel_can_be_updated()
    {
          $this->RegisterRolesAndPermissions();
        $user=User::factory()->create();
        //login with sanctum
        Sanctum::actingAs($user);
        //give permission to user by Spatie package method (givePermissionTo)
        // * use default permission which defined in config->permission.php *
        $user->givePermissionTo('channel management');

        //create Channel factory
        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);
        //update top created channel
        $response = $this->json('PUT',route('channel.update'),[
            'id' => $channel->id,
            'name' => 'vue.js'
        ]);

        //response 200 -> ok
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test delete channel should be validated
     */
    public function test_channel_delete_should_be_validated ()
    {
          $this->RegisterRolesAndPermissions();
        $user=User::factory()->create();
        //login with sanctum
        Sanctum::actingAs($user);
        //give permission to user by Spatie package method (givePermissionTo)
        // * use default permission which defined in config->permission.php *
        $user->givePermissionTo('channel management');

        $response = $this->json('DELETE',route('channel.delete'),[]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test delete channel
     */
    public function test_delete_channel()
    {
          $this->RegisterRolesAndPermissions();
        $user=User::factory()->create();
        //login with sanctum
        Sanctum::actingAs($user);
        //give permission to user by Spatie package method (givePermissionTo)
        // * use default permission which defined in config->permission.php *
        $user->givePermissionTo('channel management');

        $channel=Channel::factory()->create();
        $response = $this->json('DELETE',route('channel.delete'),[
            'id'=>$channel->id,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        //check the deleted channel is not in database
        $this->assertTrue(Channel::where('id',$channel->id)->count() === 0);
    }
}
