<?php
namespace Amk\Tmh\Exceptions;

use Exception;

class TmhException extends Exception
{

    public static function info($reason)
    {
        return new static($reason);
    }

    public static function configError($reason)
    {
        return new static('You must assign ' . $reason . ' in config (tmh.php) file.');
    }

    
}




?>