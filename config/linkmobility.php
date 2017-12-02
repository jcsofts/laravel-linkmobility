<?php
/**
 * Created by PhpStorm.
 * User: lee
 * Date: 30/11/2017
 * Time: 4:46 PM
 */
return [
    'username'=>env('LINKMOBILITY_USERNAME',''),
    'password'=>env('LINKMOBILITY_PASSWORD',''),
    'debug'=>env('LINKMOBILITY_DEBUG',true),
    'options'=>[
        'platformId'=>env('LINKMOBILITY_PLATFORM_ID',''),
        'platformPartnerId'=>env('LINKMOBILITY_PARTNER_ID',''),
        'useDeliveryReport'=>env('LINKMOBILITY_USE_DELIVERY_REPORT',''),
    ]
];