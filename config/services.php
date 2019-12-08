<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'gorpc' => [
        'keys' => env('RPC_KEYS', 'go-service'),
        'domain' => env('RPC_DOMAIN', ''),
        'port'   => env('RPC_PORT', '9001')
    ],
    'etcd' => [
        'host' => env('ETCD_HOST', 'localhost'),
        'port' => env('ETCD_PORT', '2379')
    ],

    'sm' => [
        'soar_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=10&q=%E5%A5%BD%E8%AF%84&_t=1575722208746&_=1575722208746&callback=jsonp6',
        'hot_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=10&q=%E7%83%AD%E6%90%9C&_t=1575719226479&_=1575719226480&callback=jsonp3',

        'man_xunhuan_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E7%8E%84%E5%B9%BB&_t=1575722775779&_=1575722775779&callback=jsonp19',
        'man_dushi_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E9%83%BD%E5%B8%82&_t=1575722829209&_=1575722829209&callback=jsonp20',
        'man_guanchang_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%AE%98%E5%9C%BA&_t=1575722853513&_=1575722853513&callback=jsonp21',
        'man_xiangcun_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E4%B9%A1%E6%9D%91&_t=1575722873729&_=1575722873729&callback=jsonp22',
        'man_xianxia_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E4%BB%99%E4%BE%A0&_t=1575722912778&_=1575722912779&callback=jsonp25',
        'man_junshi_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%86%9B%E4%BA%8B&_t=1575722935439&_=1575722935439&callback=jsonp26',
        'man_wangyou_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E7%BD%91%E6%B8%B8&_t=1575722957811&_=1575722957811&callback=jsonp27',
        'man_lishi_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%8E%86%E5%8F%B2&_t=1575722980882&_=1575722980882&callback=jsonp28',

        'women_gudaiyanqing_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%8F%A4%E4%BB%A3%E8%A8%80%E6%83%85&_t=1575723010616&_=1575723010616&callback=jsonp30',
        'women_xiandaiyanqing_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E7%8E%B0%E4%BB%A3%E8%A8%80%E6%83%85&_t=1575723032410&_=1575723032410&callback=jsonp31',
        'women_xianxiayanqing_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E4%BB%99%E4%BE%A0%E8%A8%80%E6%83%85&_t=1575723056476&_=1575723056476&callback=jsonp32',
        'women_badaozongcai_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E6%80%BB%E8%A3%81&_t=1575723078797&_=1575723078797&callback=jsonp33',
        'women_junhun_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%86%9B%E5%A9%9A&_t=1575723102831&_=1575723102831&callback=jsonp34',
        'women_chongwen_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%AE%A0%E6%96%87&_t=1575723121509&_=1575723121510&callback=jsonp35',
        'women_nvqiang_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%A5%B3%E5%BC%BA&_t=1575723143999&_=1575723143999&callback=jsonp36',
        'women_yanqing_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E8%A8%80%E6%83%85&_t=1575723164223&_=1575723164223&callback=jsonp37',

        'zm_xiandaizm_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E7%8E%B0%E4%BB%A3%E8%80%BD%E7%BE%8E&_t=1575795673940&_=1575795673942&callback=jsonp15',
        'zm_gufenzm_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%8F%A4%E9%A3%8E%E8%80%BD%E7%BE%8E&_t=1575795741619&_=1575795741620&callback=jsonp16',
        'zm_qgqs_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E5%BC%BA%E5%BC%BA&_t=1575795781017&_=1575795781018&callback=jsonp19',
        'zm_zmtr_url' => 'https://api.xiaoshuo1-sm.com/sc/1/channel/channel/?format=json&page={page}&size=20&q=%E8%80%BD%E7%BE%8E&_t=1575795812545&_=1575795812546&callback=jsonp20',
    ]

];
