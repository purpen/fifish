var elixir = require('laravel-elixir');

var gulp = require('gulp'),
    del = require('del');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// 清理旧文件 
gulp.task('clean', function(cb){
    del(['public/css','public/js', 'public/build'], cb); 
});

elixir(function(mix) {
    mix.task('clean');
});

elixir(function(mix) {
    mix.sass('app.scss');
});

elixir(function(mix) {
    mix.styles('base.css');
});

elixir(function(mix) {
    mix.scripts('base.js');
});


elixir(function(mix) {
    mix
        .copy('resources/assets/js/jquery-3.0.0.min.js', 'public/js/jquery-3.0.0.min.js')
        .copy('resources/assets/js/jquery-3.0.0.min.map', 'public/js/jquery-3.0.0.min.map')
        .copy('resources/assets/js/html5shiv.min.js', 'public/js/html5shiv.min.js')
        .copy('resources/assets/js/bootstrap.min.js', 'public/js/bootstrap.min.js')
        .copy('resources/assets/css/bootstrap.min.css', 'public/css/bootstrap.min.css')
        .copy('resources/assets/fonts/', 'public/fonts/');
});

// 版本号码缓存必须放在编译之后
elixir(function(mix) {
    mix
        .version([
                'css/base.css',
                'js/base.js'
            ]);
});


