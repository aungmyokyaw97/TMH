<?php

namespace Amk\Tmh\Traits;
use Amk\Tmh\Exceptions\TmhException;
use Illuminate\Support\Facades\Http;

trait TMHSMS{
    

    /**
     * [Description for getSingleConfigData]
     *
     * @param mixed $config
     * 
     * @return [type]
     * 
     */
    protected function getSingleConfigData($config){
        return isset($this->configs[$config]) ? $this->configs[$config] : $this->configError($config);
    }

    /**
     * [Description for configError]
     *
     * @param mixed $config
     * 
     * @return [type]
     * 
     */
    protected function configError($config){
        throw TmhException::configError($config);
    }

    /**
     * [Description for alphanumericRandom]
     *
     * @param mixed $length
     * 
     * @return [type]
     * 
     */
    protected function alphanumericRandom($length)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * [Description for alphabetRandom]
     *
     * @param mixed $length
     * 
     * @return [type]
     * 
     */
    protected function alphabetRandom($length)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * [Description for numericRandom]
     *
     * @param mixed $length
     * 
     * @return [type]
     * 
     */
    protected function numericRandom($length)
    {
        $pool = '0123456789';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * [Description for prepareRequest]
     *
     * @param mixed $data
     * @param mixed $phone
     * 
     * @return [type]
     * 
     */
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