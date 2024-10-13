<?php

namespace App\Listeners;

use App\Models\Enums\StatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleAdBudgetUpdate
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

        if ($ad->budget > 0 && $ad->status == StatusEnum::Pending) {
            $ad->status = StatusEnum::Active;
            $ad->save();
        }
    }
}
