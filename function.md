# 深海鱼 Fifish
----简介-----


###运行环境要求

###Laravel 方法函数记录

##### 获取超全局变量

```
env('APP_DEBUG', false);
```

##### 获取当前环境

```
App::environment();
```

##### 判断当前环境

```
if (App::environment('local', 'staging')){}
```
