<?php

use TutoraUK\Braze\Braze;

if (! function_exists('braze')) {

    function braze(): Braze
    {
        return app(Braze::class);
    }
}
