<?php


namespace App\Repositories;


use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Http\Request;

class AnswerRepository
{
    public function getAllAnswers()
    {
        return Answer::query()->latest()->get();
    }

    /**
     * @param Request $request
     */
    public function createAnswer(Request $request)
    {
        Thread::find($request->thread_id)->answers()->create([

            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);
    }
    /**
     * @param Request $request
     */
    public function updateAnswer(Request $request , Answer $answer)
    {
        $answer->update([

            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);
    }

    public function deleteAnswer($answer)
    {
        $answer->delete();
    }
}
