<?php

namespace Amk\Tmh\Tests;

use Illuminate\Support\Facades\Config;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [\Amk\Tmh\Provider\TmhServiceProvider::class];
    }


    protected function getEnvironmentSetUp($app)
    {

        $app['config']->set('tmh.spId', 11);
        $app['config']->set('tmh.spPassword', 'smstest');
        $app['config']->set('tmh.serviceId', 12);
        $app['config']->set('tmh.senderAddress', 1111);
        $app['config']->set('tmh.callbackData', 2222);
        $app['config']->set('tmh.notifyURL', ' ');
        $app['config']->set('tmh.senderName', 'TMH');
        $app['config']->set('tmh.domain', 'http://mydomain.com');
        $app['config']->set('tmh.one_api_prefix', '/api/url');
    }
}