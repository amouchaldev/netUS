<?php

namespace App\Listeners;

use App\Events\PostCommented as EventsPostCommented;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostCommented
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventsPostCommented $event)
    {
        // return 'FROM LISTENER';
    }
}
