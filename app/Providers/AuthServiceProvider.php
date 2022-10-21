<?php

namespace App\Providers;

use App\Policies\PostPolicy;
use App\Policies\ReplyPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('delete-post', [PostPolicy::class, 'destroy']);
        Gate::define('delete-reply', [ReplyPolicy::class, 'destroy']);
    }
}
