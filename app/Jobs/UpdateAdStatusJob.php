<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\Enums\StatusEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAdStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ad;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->ad->update(['status' => StatusEnum::Active]);
    }
}
