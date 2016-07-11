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
sudo chmod -R 777 storage 
```
```
sudo chmod -R 777 bootstrap/cache
```

* 安装 Laravel 之后，一般应用程序根目录会有一个 **.env** 的文件。如果没有的话，复制 **.env.example** 并重命名为 **.env** 。

```
php -r "copy('.env.example', '.env');"
```

* 更新系统秘钥
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
