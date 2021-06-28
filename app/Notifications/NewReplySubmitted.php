<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReplySubmitted extends Notification
{
    use Queueable;

    /**
     * @var Thread
     */
    private $thread;

    /**
     * Create a new notification instance.
     *
     * @param Thread $thread
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            //use thread which we give to __construct method
            'thread_title'=>$this->thread->title,
            'url'=>route('threads.show',[$this->thread]),
            'time'=>now()->format('Y-m-d H:i:s'),
        ];
    }
}
