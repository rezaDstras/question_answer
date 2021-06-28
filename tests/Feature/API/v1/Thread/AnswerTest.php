<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    //don't change in main database
    use RefreshDatabase;

    /**
     * get all answers
     *
     * @test
     */
    public function test_can_get_all_answers_list()
    {
       $response = $this->get(route('answers.index'));

       $response->assertSuccessful();
    }


    // TDD method ->first writing test after writing controller

    /**
     * answer should be validated
     *
     * @test
     */
    public function test_answer_should_be_validated()
    {
        $user=User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('answers.store'),[]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors(['content','thread_id']);
    }
    /**
     * answer could be created
     *
     * @test
     */
    public function test_answer_could_be_created()
    {
//        $this->withoutExceptionHandling();

        $user=User::factory()->create();
        Sanctum::actingAs($user);

        $thread=Thread::factory()->create();

        $response = $this->postJson(route('answers.store'),[
            'content' => 'Foo',
            'thread_id' => $thread->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            //message should be equal to message in controller
            //  "message" => "answer submitted " -> wrong
            "message" => "answer submitted successfully"
        ]);
        $this->assertTrue($thread->answers()->where('content','Foo')->exists());
    }
    /**
     *user score will increase by submit new answer
     *
     * @test
     */
    public function user_score_will_increase_by_submit_new_answer ()
    {
//        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        Sanctum::actingAs($user);

        $thread=Thread::factory()->create();

        $response = $this->postJson(route('answers.store'),[
            'content' => 'Foo',
            'thread_id' => $thread->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $user->refresh();

        //we expect increase 10 score after submit answer
        $this->assertEquals(10,$user->score);


    }
    /**
     * answer should be validated for update
     *
     * @test
     */
    public function test_answer_should_be_validated_to_update()
    {
        $user=User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create();
        $response = $this->putJson(route('answers.update',[$answer]),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content']);
    }

    /**
     * answer could be updated
     *
     * @test
     */
    public function test_own_answer_could_be_updated()
    {
//        $this->withoutExceptionHandling();

        $user=User::factory()->create();
        Sanctum::actingAs($user);

        $answer = Answer::factory()->create([
            'content' => 'Foo',
            'user_id'=>$user->id,
        ]);

        $response = $this->putJson(route('answers.update',[$answer]),[
            'content' => 'Bar',
            'thread_id' => $answer->thread_id,
        ]);



        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            //message should be equal to message in controller
            //  "message" => "answer updated " -> wrong
            "message" => "answer updated successfully"
        ]);

        //first create and then update it
        $answer->refresh();
        $this->assertEquals('Bar',$answer->content);
    }
    /**
     * own answer could be deleted
     *
     * @test
     */
    public function test_own_answer_could_be_deleted()
    {
        $user=User::factory()->create();
        Sanctum::actingAs($user);

        $answer = Answer::factory()->create([
            'user_id'=>$user->id,
        ]);

        $response = $this->delete(route('answers.destroy',[$answer]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            "message" => "answer deleted successfully"
        ]);

        $this->assertFalse(Thread::find($answer->thread_id)->answers()->whereContent($answer->content)->exists());
    }



}
