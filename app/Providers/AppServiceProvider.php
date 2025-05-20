<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\GroupPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\TestPolicy;
use App\Policies\StudentPolicy;
use App\Models\User;
use App\Policies\StudentTestPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, StudentPolicy::class);
        Gate::define('view-any-groups', [GroupPolicy::class, 'view']);
        Gate::define('manage-groups', [GroupPolicy::class, 'manage']);

        Gate::define('view-any-tests', [TestPolicy::class, 'view']);
        Gate::define('manage-tests', [TestPolicy::class, 'manage']);

        Gate::define('view-any-questions', [QuestionPolicy::class, 'view']);
        Gate::define('manage-questions', [QuestionPolicy::class, 'manage']);

        Gate::define('view-any-students', [StudentPolicy::class, 'view']);
        Gate::define('manage-students', [StudentPolicy::class, 'manage']);

        Gate::define('complete-tests', [StudentTestPolicy::class, 'view']);
        Gate::define('complete-tests', [StudentTestPolicy::class, 'view']);
    }
}
