<?php

namespace App\Listeners;

use App\Events\PostBlocked;
use Illuminate\Support\Facades\Log;

class LogBlockedPost
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostBlocked $event): void
    {
        Log::channel('blockedPosts')->info('Post ID: ', [ $event->post->id ]);
    }
}
