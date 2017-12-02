<?php

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 30/11/2017
 * Time: 4:51 PM
 */
namespace Jcsofts\LaravelLinkmobility\Facade;

use Illuminate\Support\Facades\Facade;

class Linkmobility extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Jcsofts\LaravelLinkmobility\Lib\Linkmobility::class;
    }
}