<?php 

namespace Amk\Tmh\Facades;

use Illuminate\Support\Facades\Facade;

class TMH extends Facade {

    /**
     * [Description for getFacadeAccessor]
     *
     * @return [type]
     * 
     */
    protected static function getFacadeAccessor() { 
        return \Amk\Tmh\TMH::class; 
    }

}