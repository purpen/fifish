#Fifish服务安装备忘录

***

##[Mysqld]
server_name	     mysql
config_file	     /etc/my.cnf
install_dir	     /opt/software/mysql
pid_file	     /opt/software/mysql/mysql.sock.lock
data_dir	     /data/mysql/data

server_user	     root
port		     3306

###Mysql密码设置
server_passwd	 d3in@2016#2016.2016

###Mysql启动命令
service_name	 mysqld

```
service mysqld [start|restart|reload|stop|status]
``` 

###Mysql后台管理
login_method	 mysql -u root -p[password]

***


##[nginx]
install_dir	     /opt/nginx
server_name	     nginx
server_user	     www
config_file	     /opt/nginx/conf/nginx.conf | /opt/nginx/conf/vhosts/*
pid_file	     /data/pid/nginx.pid
log_file	     /data/log/[nginx-error.log|nginx-access.log|nginx-status.log]
port		     80

###Nginx启动命令
service_name	 nginxd
command_dir	     /opt/software/nginx/sbin/
start_method	 service nginxd [start|stop|restart|reload|status]

***

##[php]
server_name	     php
server_user	     www
config_file	     /etc/php-fpm.conf & /etc/php.ini
install_dir	     /opt/php-5.6.5
pid_file	     /opt/php-5.6.5/php/var/run/php-fpm.pid
log_file	     /opt/php-5.6.5/php/var/run/php-fpm.log
port		     9000

###PHP启动命令
service_name	 php-fpm
command_dir	     /opt/software/php/bin/
```
service php-fpm [start|stop|restart|reload|status]
```

***

##[redis]
server_name	     redis
server_user	     root
config_file	     /opt/software/redis/conf/6379_redis.conf
install_dir	     /opt/software/redis
pid_file	     /opt/software/redis/pid
log_file	     /opt/software/redis/log
hard-disk_file	 /data/redis/data/
port		     6379

###Redis启动命令
service_name	 redisd
start_method	 service redisd [start|stop|restart]
command		     redis-benchmark #test_command
		         redis-cli	#command line tool
		         redis-server	#redis_service start daemon
		         redis-stat	#redis_service check_status_tool

###登陆有密码的Redis：
在登录的时候的时候输入密码：
```
redis-cli  -h 10.104.153.89 -p 6379 -a fifish@2016#2016.2016
```                 
先登陆后验证：
```
redis 127.0.0.1:6379> auth fifish@2016#2016.2016
```
                    
***

想要了解更多，请阅读[readme.md](http://www.qysea.com)文档。

![](http://www.qysea.com/img/logo_fifish.png)
