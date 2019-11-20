<?php

namespace App\Listeners;

use App\Events\MobilePushNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendMobileNotification
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
     * @param  MobilePushNotification  $event
     * @return void
     */
    public function handle(MobilePushNotification $event)
    {
        //
    }
}
