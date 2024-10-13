<?php

namespace App\Listeners;

use App\Models\Ad;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class HandleCampaignStatusUpdate
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
        $campaign = $event->campaign;
        Ad::where('campaign_id', $campaign->id)->update(['status' => $campaign->status]);
    }
}
