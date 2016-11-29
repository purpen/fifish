<?php

namespace App\Providers;

use DB;
use Log;
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
        \Carbon\Carbon::setLocale('zh');
        
        // 定义多态对照表
        Relation::morphMap([
            'Stuff' => \App\Http\Models\Stuff::class,
            'Comment' => \App\Http\Models\Comment::class,
            'Like' => \App\Http\Models\Like::class,
            'User' => \App\Http\Models\User::class,
            'Tag' => \App\Http\Models\Tag::class,
            'Column' => \App\Http\Models\Column::class,
            'Follow' => \App\Http\Models\Follow::class
        ]);
            
        // 监听sql执行情况
        DB::listen(
            function($sql) {
                // var_dump($sql);
                // $sql is an object with the properties:
                //  sql: The query
                //  bindings: the sql query variables
                //  time: The execution time for the query
                //  connectionName: The name of the connection

                // To save the executed queries to file:
                // Process the sql and the bindings:
                foreach ($sql->bindings as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } else {
                        if (is_string($binding)) {
                            $sql->bindings[$i] = "'$binding'";
                        }
                    }
                }
                // Insert bindings into query
                $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);

                $query = vsprintf($query, $sql->bindings);
                
                // 添加执行时间
                $query .= ' '.$sql->time.'ms';
                
                // Log::debug($query);
            }
        );
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
