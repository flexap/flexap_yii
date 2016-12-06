<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.yandex.ru',
        'username' => 'myemail@yandex.ru',
        'password' => '',
        'port' => '465',
        'encryption' => 'ssl',
    ],
    'useFileTransport' => false,
];
