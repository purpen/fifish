<?php
/**
 * 常量配置参数
 */

return [

    /*
    |--------------------------------------------------------------------------
    | 第三方默认密码设置
    |--------------------------------------------------------------------------
    */

    'wechat' => [
        'type' => 2,
        'password' => 'wx10@Qy01'
    ],
    
    'facebook' => [
        'type' => 3,
        'password' => 'fb11@Qy10'
    ],
    
    'instagram' => [
        'type' => 4,
        'password' => 'in12@Qy14'
    ],
    
    /*
    |--------------------------------------------------------------------------
    | 提醒事件
    |--------------------------------------------------------------------------
    */
    'events' => [
        'post' => 1,
        'comment' => 2,
        'like' => 3,
        'follow' => 4,
        'at' => 5,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | 个人标签身份
    |--------------------------------------------------------------------------
    */
    'idtags' => [
        '肌肉男','路人甲','老炮儿','特种兵','小鲜肉','先锋派','梦想家','夜猫子','老司机'
    ],
    
];
