<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Client;
use App\Models\ContactLead;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use App\Observers\ActivityLogObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        Vite::prefetch(concurrency: 3);

        // Log aktivitas admin panel untuk seluruh model konten
        foreach ([
            Category::class, Client::class, ContactLead::class, Page::class,
            Post::class, Project::class, ProjectImage::class, Service::class,
            Setting::class, Slider::class, Team::class, Testimonial::class, User::class,
        ] as $model) {
            $model::observe(ActivityLogObserver::class);
        }

        Event::listen(Login::class, function (Login $event) {
            ActivityLog::create([
                'user_id' => $event->user->getAuthIdentifier(),
                'action_type' => 'login',
                'model_type' => User::class,
                'model_id' => $event->user->getAuthIdentifier(),
                'description' => 'Login ke panel admin: ' . $event->user->email,
            ]);
        });

        Event::listen(Logout::class, function (Logout $event) {
            if (! $event->user) {
                return;
            }
            ActivityLog::create([
                'user_id' => $event->user->getAuthIdentifier(),
                'action_type' => 'logout',
                'model_type' => User::class,
                'model_id' => $event->user->getAuthIdentifier(),
                'description' => 'Logout dari panel admin: ' . $event->user->email,
            ]);
        });
    }
}
