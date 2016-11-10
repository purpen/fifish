<?php

namespace App\Providers;

use App\Http\Models\User;
use App\Http\Models\Comment;
use App\Http\Models\Feedback;
use App\Http\Models\Follow;
use App\Http\Models\Like;

use App\Observers\UserObserver;
use App\Observers\CommentObserver;
use App\Observers\FeedbackObserver;
use App\Observers\FollowObserver;
use App\Observers\LikeObserver;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PodcastWasPurchased' => [
            'App\Listeners\EmailPurchaseConfirmation',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
        
        // 添加用户观察者
        User::observe(new UserObserver);
        
        // 添加评论观察者
        Comment::observe(new CommentObserver);
        
        // 添加意见反馈观察者
        Feedback::observe(new FeedbackObserver);
        
        // 添加关注观察者
        Follow::observe(new FollowObserver);
        
        // 添加点赞观察者
        Like::observe(new LikeObserver);
    }
}
