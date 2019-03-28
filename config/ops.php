<?php

return [

    'white_list' => env('OPS_WHITE_LIST', ''), // 白名单 数组
    'white_list_enable' => env('WHITE_LIST_ENABLE', false), // 白名单开关
    'app_id' => env('OPS_APP_ID', ''), // app_id
    'secret_key' => env('OPS_SECRET_KEY', ''), // 对应的secret_key
];