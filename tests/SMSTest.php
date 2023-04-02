<?php

namespace Amk\Tmh\Tests;

use Amk\Tmh\TMH;
use Amk\Tmh\Tests\TestCase;

class SMSTest extends TestCase
{
    public function testSmsWithValidArg(){           
        $tmh = new TMH();
        $this->assertIsObject($tmh->sms('sms'));
    }

    public function testSmsWithoutValidArg(){           
        $this->expectException(\ArgumentCountError::class);
        $tmh = new TMH();
        $this->assertIsObject($tmh->sms());
    }

    public function testOtpWithValidArg(){
        $tmh = new TMH();
        $this->assertIsObject($tmh->otp());
    }

    public function testSendWithoutValidArg(){
        $this->expectException(\ArgumentCountError::class);
        $tmh = new TMH();
        $this->assertIsObject($tmh->send());
    }


    

}