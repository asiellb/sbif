<?php namespace Asiellb\Sbif\Exception;

use Exception;

class ApikeyNotFoundException extends Exception
{
    function __construct()
    {
        parent::__construct("Api key not found");
    }
}
