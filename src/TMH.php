<?php

namespace Amk\Tmh;

use Amk\Tmh\Contracts\TmhServiceContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Amk\Tmh\Exceptions\TmhException;
use Amk\Tmh\Traits\TMHSMS;

class TMH implements TmhServiceContract
{
    use TMHSMS;

    /**
     * [Description for $spId]
     *
     * @var [type]
     */
    protected $spId;
    
    /**
     * [Description for $spPassword]
     *
     * @var [type]
     */
    protected $spPassword;
   
    /**
     * [Description for $serviceId]
     *
     * @var [type]
     */
    protected $serviceId;
    
    /**
     * [Description for $senderAddress]
     *
     * @var [type]
     */
    protected $senderAddress;
    
    /**
     * [Description for $callbackData]
     *
     * @var [type]
     */
    protected $callbackData;
    
    /**
     * [Description for $notifyURL]
     *
     * @var [type]
     */
    protected $notifyURL;
    
    /**
     * [Description for $senderName]
     *
     * @var [type]
     */
    protected $senderName;
    
    /**
     * [Description for $domain]
     *
     * @var [type]
     */
    protected $domain;
    
    /**
     * [Description for $one_api_prefix]
     *
     * @var [type]
     */
    protected $one_api_prefix;
    
    /**
     * [Description for $URL]
     *
     * @var [type]
     */
    protected $URL;
    
    /**
     * [Description for $messageType]
     *
     * @var [type]
     */
    protected $messageType;

    /**
     * [Description for $message]
     *
     * @var [type]
     */
    protected $message;
    
    /**
     * [Description for $otp]
     *
     * @var [type]
     */
    protected $otp;
    
    /**
     * [Description for $configs]
     *
     * @var [type]
     */
    protected $configs;

    /**
     * [Description for __construct]
     *
     * 
     */
    function __construct()
    {
        $this->configs = Config('tmh') != null ? Config('tmh') : throw TmhException::info('You need to publish config file.');
        $this->ConfigData();
    }


    /**
     * [Description for ConfigData]
     *
     * @return [type]
     * 
     */
    
    private function ConfigData(){
        $this->spId = $this->getSingleConfigData('spId');
        $this->spPassword = $this->getSingleConfigData('spPassword');
        $this->serviceId = $this->getSingleConfigData('serviceId');
        $this->senderAddress = $this->getSingleConfigData('senderAddress');
        $this->callbackData = $this->getSingleConfigData('callbackData');
        $this->notifyURL = $this->getSingleConfigData('notifyURL');
        $this->senderName = $this->getSingleConfigData('senderName');
        $this->domain = $this->getSingleConfigData('domain');
        $this->one_api_prefix = $this->getSingleConfigData('one_api_prefix');
        $this->URL = $this->domain . '/' . $this->one_api_prefix;
    }


    /**
     * [Description for sms]
     *
     * @param string $message
     * 
     * @return [type]
     * 
     */

    public function sms(string $message){           
        $this->message = $message;
        $this->messageType = "SMS";
        return $this;
    }


    // type => alphabet / numeric / alphanumeric
    /**
     * [Description for otp]
     *
     * @param string $type
     * @param int $length
     * 
     * @return [type]
     * 
     */

    public function otp(string $type = 'numeric',int $length = 6){           
        $this->messageType = "OTP";

        switch ($type) {
            case 'alphabet':
                $this->otp = $this->alphabetRandom($length);
                $this->message = trans('tmh::otp.message', ['otp' => $this->otp]);
                break;
            case 'alphanumeric':
                $this->otp = $this->alphanumericRandom($length);
                $this->message = trans('tmh::otp.message', ['otp' => $this->otp]);
                break;
            case 'numeric':
                $this->otp = $this->numericRandom($length);
                $this->message = trans('tmh::otp.message', ['otp' => $this->otp]);
                break;
            default:
            throw TmhException::info('Unknow OTP type.');
        }
        return $this;
    }

    /**
     * [Description for makeResponse]
     *
     * @param mixed $response
     * @param mixed $phone
     * 
     * @return object
     * 
     */

    protected function makeResponse($response,$phone): object{           

        if ($response->status() != 200) {
            throw TmhException::info($response->body());
        }

        $myCollection = [
            "messageType" => $this->messageType,
            "message" => $this->message,
            "phone" => $phone,
            "SMS_Data" => json_decode($response->body()),
        ];

        if ($this->messageType == "OTP") {
           $myCollection['OTP'] = $this->otp;
        }

        return  (object) $myCollection;
    }


    /**
     * [Description for send]
     *
     * @param mixed $phone
     * 
     * @return [type]
     * 
     */
    
    public function send($phone){
        $phoneNo = is_array($phone) ? $phone : [$phone];
        $response = $this->prepareRequest($this,$phoneNo);
        return $this->makeResponse($response,$phone);
    }
  
}