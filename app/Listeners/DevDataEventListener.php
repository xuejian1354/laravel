<?php

namespace App\Listeners;

use App\Events\DevDataEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Input;

class DevDataEventListener
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
     * @param  DevDataEvent  $event
     * @return void
     */
    public function handle(DevDataEvent $event)
    {
    	if(Input::get('action') == 'test') {
    		$event->test();
    	}
    }
}
