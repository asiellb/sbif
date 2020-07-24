<?php namespace Asiellb\Sbif\Exception;

use Exception;

class RequestException extends Exception
{
    function __construct($endpoint)
    {
        parent::__construct("Request exception ($endpoint)");
    }
}
