<?php


namespace App\Repositories;


use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadRepository
{

    public function getAllThreads()
    {
        return $threads = Thread::whereFlag(1)->latest()->get();
    }


    public function showThreadBySlug($slug)
    {
       return Thread::whereSlug($slug)->whereFlag(1)->first();
    }

    /**
     * @param Request $request
     */
    public function createThread(Request $request)
    {
        Thread::query()->create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'content' => $request->input('content'),
            'channel_id' => $request->input('channel_id'),
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * @param Request $request
     */
    public function updateThread(Request $request,Thread $thread)
    {

        //if dont have best answer
        if (!$request->has('best_answer_id')) {
            $thread->update([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title')),
                'content' => $request->input('content'),
                'channel_id' => $request->input('channel_id'),
            ]);
        } else {
            $thread->update([
                'best_answer_id' => $request->input('best_answer_id')
            ]);
        }
    }

    public function destroyThread(Thread $thread)
    {
        $thread->delete();
    }

}
