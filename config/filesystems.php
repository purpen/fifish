<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'qiniu',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],
        
        'qiniu' => [
            'driver'  => 'qiniu',
            'upload_url' => 'http://up-z2.qiniu.com',
            'domains' => [
                'default'   => 'oe5tkubcj.bkt.clouddn.com', // 你的七牛域名
                'https'     => 'fs.qysea.com',         // 你的HTTPS域名
                'custom'    => 'http://oe5tkubcj.bkt.clouddn.com',         // 你的自定义域名
             ],
            'access_key'=> 'x9Ys5weZ-B6-qKywyX2N34bhFIT3XQLpxz0g9vZU',  //AccessKey
            'secret_key'=> 'BqjfA2zx5JgxAS2N5NKH6kAvPsr3NnD4pY84j2Fm',  //SecretKey
            'bucket'    => 'fifish',  //Bucket名字
            'notify_url'=> 'http://api.qysea.com/upload/qiniuback',  //持久化处理回调地址
        ],

    ],

];
