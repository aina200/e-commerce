<?php

return [

    // ____ Framewa services definitions
    // __ You really shouldn't be touching these. (:
    'framewa.config_reader' => [
        'class' => \Framewa\Config\ConfigReader::class
    ],
    'framewa.router' => [
        'class' => \Framewa\Http\Router::class
    ],
    'framewa.database' => [
        'class' => \Framewa\Connection\Database::class
    ],
    'framewa.session' => [
        'class' => \Framewa\Auth\Session::class
    ],
    'framewa.authenticator' => [
        'class' => \Framewa\Auth\Authenticator::class
    ]

    // ____ Add your services here
    // __ Example:
    //    'app.money_formatter' => [
    //        'class' => App\Util\MoneyFormatter::class,
    //        'arguments' => [
    //            'currency' => '$'
    //        ]
    //    ]

];
