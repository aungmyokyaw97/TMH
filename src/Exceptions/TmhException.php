<?php
namespace Amk\Tmh\Exceptions;

use Exception;

class TmhException extends Exception
{

    /**
     * [Description for info]
     *
     * @param mixed $reason
     * 
     * @return [type]
     * 
     */
    public static function info($reason)
    {
        return new static($reason);
    }

    /**
     * [Description for configError]
     *
     * @param mixed $reason
     * 
     * @return [type]
     * 
     */
    public static function configError($reason)
    {
        return new static('You must assign ' . $reason . ' in config (tmh.php) file.');
    }

    
}




?>