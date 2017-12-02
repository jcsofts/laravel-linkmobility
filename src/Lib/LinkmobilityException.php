<?php
/**
 * Created by PhpStorm.
 * User: lee
 * Date: 01/12/2017
 * Time: 11:37 AM
 */

namespace Jcsofts\LaravelLinkmobility\Lib;


class LinkmobilityException extends \Exception
{
    const ERROR_MESSAGE=[
        '106000'=>'Unknown Error. Please contact Support and include your whole transaction.',
        '106100'=>'Invalid authentication. Please check your username and password.',
        '106101'=>'Access denied. Please check your username and password.',
        '106200'=>'Invalid or missing platformId. Please check your platformId.',
        '106201'=>'Invalid or missing platformPartnerId. Please check your platformPartnerId.',
        '106202'=>'Invalid or missing currency for premium message. Please check your price and currency.',
        '106300'=>'No gates available. Please contact Support and include your whole transaction.',
        '106301'=>'Specified gate available. Please check your gateId.'
    ];

    private $resultCode;

    public static function fromResultCode($resultCode){
        if(array_key_exists($resultCode,self::ERROR_MESSAGE)){
            $message = self::ERROR_MESSAGES[$resultCode];
        } else {
            $message = 'Unknown Linkmobility API error';
        }
        $exception = new self($message);
        $exception->resultCode = $resultCode;
        return $exception;
    }
}