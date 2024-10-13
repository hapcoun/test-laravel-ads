<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Ad;
use App\Models\Enums\StatusEnum;
use Illuminate\Support\Facades\DB;

class CampaignService
{
    /**
     * @param Campaign $campaign
     * @param string $status
     * @return bool
     */
    public function updateCampaignStatus(Campaign $campaign, string $status): bool
    {
        DB::transaction(function () use ($campaign, $status) {
            $campaign->status = $status;
            $campaign->save();

            Ad::where('campaign_id', $campaign->id)->update(['status' => $status]);
        });

        return true;
    }
}
