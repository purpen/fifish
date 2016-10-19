# 深海鱼 Fifish
----简介-----


###运行环境要求

* PHP >= 5.5.9
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension

建议环境：Nginx 1.10 / PHP 5.6 / MariaDB 10.1(Mysql 5.6) / Laravel 5.1
使用说明：[英文文档](https://laravel.com/docs/5.1)；[中文文档](http://laravel-china.org/docs/5.1)。

###安装使用

#####第一步：安装composer包管理器

访问[composer](http://pkg.phpcomposer.com/)，根据文档说明安装composer。
    
#####第二步：开发环境生成ssh公钥。

```
ssh-keygen -t rsa -C "your email!"
```

#####第三步：克隆fifish代码

```
git clone git@github.com:purpen/fifish.git
```

#####第四步：composer安装框架文件

```
composer install
```

######Remark
* 安装 Laravel 之后，需要你配置 **storage** 和 **bootstrap/cache** 目录的读写(777)权限。

```
sudo chmod -R 777 bootstrap/cache
```
* 如出现无法正常访问，并且日志为空，请检测日志权限
```
sudo chmod -R 777 storage/logs/xxx.log
```
```
sudo chmod -R 777 storage 
sudo chmod -R 777 storage/framework/cache
sudo chmod -R 777 storage/framework/views
```

* 安装 Laravel 之后，一般应用程序根目录会有一个 **.env** 的文件。如果没有的话，复制 **.env.example** 并重命名为 **.env** 。

```
php -r "copy('.env.example', '.env');"
```

* 更新系统秘钥 （错误：No supported encrypter found，laravel5.1开始APP_KEY必须是长度32且有cipher）
```
php artisan key:generate
```
* 重新加载插件
```
composer dump-autoload
```
* 自定义函数库和类库目录
```
app/helper.php和app/Libraries/
```

######数据库
* 创建数据库 fifish

######基本配置
nginx加上优雅链接:

location / {
    try_files $uri $uri/ /index.php?$query_string;
}

######生成API文档
apidoc -i app/Http/Controllers/Api/ -o public/apidoc


######使用Redis作为缓存及任务队列
```
Redis: predis/predis ~1.0
```

#Queue队列特别注意的问题
>如果为任务指定队列【queuename】,则执行任务时，必须指定--queue=queuename队列参数，否则，php artisan queue:listen监测并执行默认队列，不会执行某个特定队列

```
php artisan queue:listen redis --queue=stats,emails
```

#LARAVEL  REDIS 与 REDIS 扩展冲突.
Laravel 的 redis 结果报了如下错误:
>Non-static method Redis::xxx() cannot be called statically, assuming $this from incompatible context
Laravel 自带的 Redis 可以是使用, 如下代码:
>use Illuminate\Support\Facades\Redis as Redis;


######Mysql修改某字段
alter table assets modify column size double(15,2);

######Mysql删除某字段
alter table assets drop column vbyte;

######Mysql查看数据表结构
desc assets;

###### 全文索引
path: /opt/software/xunsearch
start: /opt/software/xunsearch/bin/xs-ctl.sh restart -b inet start

