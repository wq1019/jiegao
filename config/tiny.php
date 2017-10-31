<?php

return [
    // 用户的默认密码
    'default_user_password' => 'test1234',

    'max_per_page' => 40,
    'default_per_page' => 15,

    'default_slug_mode' => 'pinyin',

    'logo' => env('LOGO', 'tiny'),

    // 阅读间隔，每个用户在此时间内重复刷新文章页面只增长 1 个阅读量，单位分钟
    'reading_interval' => 1,

    // 尝试登录不需要验证码的次数
    'need_not_verification_code_times' => 3,

    // 尝试登录不需要验证码的时间间隔
    'not_verification_code_time_interval' => 60*24
];
