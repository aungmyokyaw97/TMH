<?php

namespace Amk\Tmh;

use Illuminate\Support\Collection;
use Amk\Tmh\Exceptions\TmhException;
use Amk\Tmh\Traits\TMHSMS;

class TMH
{
    use TMHSMS;

    protected $spId;
    protected $spPassword;
    protected $serviceId;
    protected $senderAddress;
    protected $callbackData;
    protected $notifyURL;
    protected $senderName;
    protected $domain;
    protected $one_api_prefix;
    protected $URL;
    protected $messageType;

    protected $message;
    protected $otp;
    protected $configs;

    function __construct()
    {
        $this->configs = file_exists(config_path('tmh.php')) ? include(config_path('tmh.php')) : throw TmhException::info('You need to publish config file.');
        $this->ConfigData();
    }


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


    public function sms(string $message){           
        $this->message = $message;
        $this->messageType = "SMS";
        return $this;
    }


    // type => alphabet / numeric / alphanumeric
    public function otp($type = 'numeric',$length = 6){           
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
            default:
                $this->otp = $this->numericRandom($length);
                $this->message = trans('tmh::otp.message', ['otp' => $this->otp]);
                break;
        }
        return $this;
    }

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


    public function send($phone){
        $phoneNo = is_array($phone) ? $phone : [$phone];
        $response = $this->prepareRequest($this,$phoneNo);
        return $this->makeResponse($response,$phone);
        
    }
}