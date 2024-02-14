<?php

namespace CitadelKit\Garuda\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CitadelKit\Garuda\Garuda
 */
class Garuda extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \CitadelKit\Garuda\Garuda::class;
    }
}
