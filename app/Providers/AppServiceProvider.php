<?php

namespace App\Providers;
// use App\Post;
// use App\Observers\PostObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // \App\Post::creating(function($model){
        //     $model->title = strtoupper($model->title);
        // });
        // Post::observe(PostObserver::class);

    }
}
