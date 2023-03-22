<?php 

namespace Amk\Tmh\Facades;

use Illuminate\Support\Facades\Facade;

class TMH extends Facade {

    protected static function getFacadeAccessor() { 
        return \Amk\Tmh\TMH::class; 
    }

}