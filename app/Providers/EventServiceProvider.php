<?php

namespace App\Providers;

use App\Events\AdBudgetUpdated;
use App\Events\CampaignStatusUpdated;
use App\Listeners\HandleAdBudgetUpdate;
use App\Listeners\HandleCampaignStatusUpdate;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\AdStatusUpdated;
use App\Listeners\HandleAdStatusUpdate;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CampaignStatusUpdated::class => [
            HandleCampaignStatusUpdate::class,
        ],
        AdStatusUpdated::class => [
            HandleAdStatusUpdate::class,
        ],
        AdBudgetUpdated::class => [
            HandleAdBudgetUpdate::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
