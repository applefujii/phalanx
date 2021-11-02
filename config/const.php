<?php

return [
    //ページネーション
    'pagination' => 25,

    // 適性診断の区分
    'category' => [
        '生活面' => 1,
        '社会面' => 2,
        '就職面' => 3,
    ],

    // 適性診断の選択肢
    'option' =>[
        'yes' => 1,
        'no' => -1,
        'unknown' => 0,
    ],

    'option_japanese' =>[
        'yes' => 'はい',
        'no' => 'いいえ',
        'unknown' => 'どちらともいえない',
    ],

];