<?php

namespace App\Providers;

use App\Models\Campaign;
use App\Models\Ad;
use App\Policies\CampaignPolicy;
use App\Policies\AdPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $policies = [
        Campaign::class => CampaignPolicy::class,
        Ad::class => AdPolicy::class,
    ];

    public function boot(): void {
        $this->registerPolicies();

        Gate::resource('campaigns', CampaignPolicy::class);
        Gate::resource('ads', AdPolicy::class);
    }
}
