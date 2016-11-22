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

var elixir = require('laravel-elixir'),
    gulp = require('gulp'),
    del = require('del');
    
// 关闭默认源地图
elixir.config.sourcemaps = false;

// 调用存在的Task任务
gulp.task('clean', function(cb) {
    del(['public/css','public/js'], cb); 
});

elixir(function(mix) {
    mix.task('clean');
});

// 编译Less文件
elixir(function(mix) {
    mix.less(['app.less'], 'public/css/app.css');
    mix.less(['admin.less'], 'public/css/admin.css');
    mix.less(['wap.less'], 'public/css/wap.css');
});

// 将原生CSS样式文件合并到一个文件
elixir(function(mix) {
   mix.styles([
       'bootstrap.css',
       'bootstrap-theme.css'
   ], 'public/css/bootstrap.min.css');
   
   mix.styles([
       'AdminLTE.css',
       'skins/skin-blue.css'
   ], 'public/css/AdminLTE.min.css');
   
   mix.styles([
       'font-awesome.css',
   ], 'public/css/font-awesome.min.css');
   
   mix.styles([
       'dataTables.bootstrap.css',
       'select2.css',
       'swiper-3.4.0.min.css',
   ], 'public/css/bootstrap.plugins.min.css');
});

// 将编译Javascript文件
elixir(function(mix) {
    mix.scripts(['jquery-3.0.0.min.js'], 'public/js/jquery-3.0.0.min.js');
    mix.scripts([
        'bootstrap.js'
    ], 'public/js/bootstrap.min.js');
    mix.scripts(['AdminLTE.js'], 'public/js/AdminLTE.min.js');
    mix.scripts([
        'select2.full.js',
        'jquery.form.js',
        'jquery.fineuploader-3.5.0.js',
        'swiper-3.4.0.jquery.min.js'
    ], 'public/js/jquery.plugins.min.js');
    mix.scripts(['app.js'], 'public/js/app.js');
});

elixir(function(mix) {
    mix.copy('resources/assets/fonts/', 'public/fonts/');
    mix.copy('resources/assets/img/', 'public/img/');
    mix.copy('resources/assets/js/plupload', 'public/js/plupload');
});

// 添加版本号
elixir(function(mix) {
   mix.version([
      'css/app.css',
      'css/admin.css',
      'css/wap.css',
      'css/bootstrap.plugins.min.css',
      'js/jquery.plugins.min.js',
      'js/app.js' 
   ]); 
});