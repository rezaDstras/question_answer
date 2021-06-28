<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    /**
     * subscribe thread.
     *
     * @test
     */
    public function test_can_subscribe_to_a_Thread()
    {

//        $this->withoutExceptionHandling();

        $user=User::factory()->create();
        Sanctum::actingAs($user);

        $thread =Thread::factory()->create();
        $response = $this->postJson(route('subscribe',[$thread]));

        $response->assertSuccessful();

        $response->assertJson([
            "message"=> "user subscribed successfully"
        ]);
    }
    /**
     * unSubscribe thread.
     *
     * @test
     */
    public function test_can_unSubscribe_to_a_Thread()
    {

//        $this->withoutExceptionHandling();

        $user=User::factory()->create();
        Sanctum::actingAs($user);

        $thread =Thread::factory()->create();
        $response = $this->postJson(route('unSubscribe',[$thread]));

        $response->assertSuccessful();

        $response->assertJson([
            "message"=> "user unsubscribed successfully"
        ]);
    }
    /**
     * unSubscribe .
     *
     * @test
     */
    public function notification_will_send_to_subscribes_of_threads()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        Sanctum::actingAs($user);

        //use notification fake in laravel
        Notification::fake();

        $thread=Thread::factory()->create();

        $Subscribe_response = $this->postJson(route('subscribe',[$thread]));

        $Subscribe_response->assertSuccessful();

        $Subscribe_response->assertJson([
            "message"=> "user subscribed successfully"
        ]);

        $answer_response=$this->postJson(route('answers.store'),[
            'content'=>'Foo',
            'thread_id'=>$thread->id,
        ]);

        $answer_response->assertSuccessful();
        $answer_response->assertJson([
            "message"=> "answer submitted successfully"
        ]);

        //test send notification to user
        //NewReplySubmitted created for Thread notification
        Notification::assertSentTo($user,NewReplySubmitted::class);

    }


}
