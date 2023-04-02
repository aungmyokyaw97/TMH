<?php

namespace amk\tmh\Contracts;

interface TmhServiceContract
{
    public function sms(string $message);
    
    public function otp(string $type,int $length);

    public function send($phone);
}