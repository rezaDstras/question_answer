<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    /**
     * All threads should be accessible
     *
     * @test
     */
    public function test_all_threads_list_should_be_accessible()
    {
        $response = $this->get(route('threads.index'));

        $response->assertStatus(Response::HTTP_OK);
    }
    /**
     *  thread should be accessible by slug
     *
     * @test
     */
    public function test_thread_should_be_accessible_by_slug()
    {
        $thread=Thread::factory()->create();
        $response = $this->get(route('threads.show',[$thread->slug]));

        $response->assertStatus(Response::HTTP_OK);
    }
    /**
     *  thread should be validated to store
     *
     * @test
     */
    public function test_thread_should_be_validated_to_store()
    {

        $user=User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('threads.store', []));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    /**
     *  thread could be created
     *
     * @test
     */
    public function test_thread_could_be_created()
    {
         //$this->withoutExceptionHandling();

        $user=User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('threads.store', [
            'title'=>'foo',
            'content'=>'foo',
            'channel_id'=>Channel::factory()->create()->id,
        ]));

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     *  thread should be validated to update
     *
     * @test
     */
    public function test_thread_should_be_validated_to_update()
    {

        $user=User::factory()->create();
        Sanctum::actingAs($user);
        $thread=Thread::factory()->create();
        $response = $this->putJson(route('threads.update', [$thread]),[]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     *  thread could be updated
     *
     * @test
     */
    public function test_thread_could_be_updated()
    {


        $user=User::factory()->create();
        Sanctum::actingAs($user);
        $thread=Thread::factory()->create([
            'title'=>'foo',
            'content'=>'bar',
            'channel_id'=>Channel::factory()->create()->id,
            'user_id' => $user->id
        ]);
        $response = $this->putJson(route('threads.update', [$thread]),[
            'title'=>'bar',
            'content'=>'foo',
            'channel_id'=>Channel::factory()->create()->id,
        ])->assertSuccessful();

        //first create thread and refresh to edit data and check
        $thread->refresh();

        $this->assertSame('bar',$thread->title);

//        $response->assertStatus(Response::HTTP_OK);
    }
    /**
     *  thread could be created
     *
     * @test
     */
    public function test_thread_could_add_best_answer()
    {

        $user=User::factory()->create();
        Sanctum::actingAs($user);
        $thread=Thread::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->putJson(route('threads.update', [$thread]),[
            'best_answer_id'=>1,
        ])->assertSuccessful();

        //first create thread and refresh to edit data and check
        $thread->refresh();

        $this->assertSame(1,$thread->best_answer_id);

//        $response->assertStatus(Response::HTTP_OK);
    }
    /**
     *  thread could be deleted
     *
     * @test
     */
    public function test_could_be_deleted ()
    {
        $user=User::factory()->create();
        Sanctum::actingAs($user);
        $thread=Thread::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this->delete(route('threads.destroy',[$thread->id]));

        $response->assertStatus(Response::HTTP_OK);
    }
}
