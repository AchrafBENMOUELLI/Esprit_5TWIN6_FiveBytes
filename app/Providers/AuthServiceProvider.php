<?php

namespace App\Providers;

use App\Models\Incident\Incident;
use App\Models\Incident\IncidentComment;
use App\Policies\IncidentPolicy;
use App\Policies\IncidentCommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Incident::class => IncidentPolicy::class,
        IncidentComment::class => IncidentCommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
