<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 定义多态对照表
        Relation::morphMap([
            'Stuff' => \App\Http\Models\Stuff::class,
            'Comment' => \App\Http\Models\Comment::class,
            'Like' => \App\Http\Models\Like::class,
            'User' => \App\Http\Models\User::class,
            'Tag' => \App\Http\Models\Tag::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
