<?php

/**
 * Created by PhpStorm.
 * User: lee
 * Date: 30/11/2017
 * Time: 4:51 PM
 */
namespace Jcsofts\LaravelLinkmobility\Lib;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class Linkmobility
{
    const API_URL="https://wsx.sp247.net/";
    const SEND_SMS_ENDPOINT = 'sms/send';
    /**
     * @var
     */
    private $username;

    /**
     * @var
     */
    private $password;


    private $debug=false;

    private $defaultOptions;

    public function __construct($username,$password,$debug,$defaultOptions)
    {
        $this->username=$username;
        $this->password=$password;
        $this->debug=$debug;
        $this->defaultOptions=$defaultOptions;
    }


    public function send(string $text, string $to, string $source = 'LINK',$parameters=null){
        $client = new Client([
            RequestOptions::AUTH => [$this->username, $this->password],
            'base_uri' => self::API_URL
        ]);

        $data=[
            'source'=>$source,
            'destination'=>$to,
            'userData'=>$text,
        ];

        //merger the default options
        $data = array_merge($data,$this->defaultOptions);
        if($parameters!=null){
            $data = array_merge($data,$parameters);
        }

        try {
            $res = $client->request("POST",self::SEND_SMS_ENDPOINT, [
                'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json'],
                'json' => $data,
                "debug" => $this->debug
            ]);
            return $this->getResponse($res);
        } catch (ClientException $e) {
            throw $e;
        }

    }

    /**
     * @param ResponseInterface $response
     *
     * @return string
     *
     * @throws LinkmobilityException
     */
    private function getResponse(ResponseInterface $response) : string
    {
        $statusCode=$response->getStatusCode();
        if($statusCode==200){
            $result=json_decode($response->getBody()->getContents(),true);
            if($result['resultCode']=='1005'){
                return $result['messageId'];
            }else{
                throw LinkmobilityException::fromResultCode($result['resultCode']);
            }

        }else if($statusCode==204){
            return 'successful';
        }
    }

}