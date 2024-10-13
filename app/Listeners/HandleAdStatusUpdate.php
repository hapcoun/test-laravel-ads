<?php

namespace App\Listeners;

use App\Jobs\UpdateAdStatusJob;
use App\Models\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleAdStatusUpdate
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
    public function handle(object $event): void
    {
        $ad = $event->ad;

        if ($ad->status == StatusEnum::Pending) {
            UpdateAdStatusJob::dispatch($ad)->delay(Carbon::now()->addMinutes(3));
        }
    }
}
