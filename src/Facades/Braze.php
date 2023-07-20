<?php

namespace TutoraUK\Braze\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TutoraUK\Braze\Braze
 */
class Braze extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TutoraUK\Braze\Braze::class;
    }
}
