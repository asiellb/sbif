<?php namespace Asiellb\Sbif\Facades;

use Illuminate\Support\Facades\Facade;
use Asiellb\Sbif\Sbif;

class SbifFacade extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return Sbif::class;
    }
}
