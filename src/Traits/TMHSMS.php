<?php

namespace Amk\Tmh\Traits;
use Amk\Tmh\Exceptions\TmhException;
use Illuminate\Support\Facades\Http;

trait TMHSMS{
    

    protected function getSingleConfigData($config){
        return isset($this->configs[$config]) ? $this->configs[$config] : $this->configError($config);
    }

    protected function configError($config){
        throw TmhException::configError($config);
    }

    protected function alphanumericRandom($length)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    protected function alphabetRandom($length)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    protected function numericRandom($length)
    {
        $pool = '0123456789';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    protected function prepareRequest($data,$phone)
    {
        $response = Http::withHeaders([
            'Accept-Encoding' => 'gzip,deflate',
            'Content-Type' => 'application/json',
            'Authorization' => 'spId='.$data->spId.',spPassword='.$data->spPassword.',timeStamp="20200409150800",serviceId='.$data->serviceId,
            'Accept' => 'application/json',
        ])->post($data->URL, [
            'address' => $phone,
            'senderAddress' => $data->senderAddress,
            'message' => $data->message,
            'callbackData' => $data->callbackData,
            'notifyURL' => $data->notifyURL,
            'senderName' => $data->senderName,
        ]);

        return $response;
    }





}