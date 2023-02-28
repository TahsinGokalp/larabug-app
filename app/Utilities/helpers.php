<?php

if (! function_exists('carbon')) {
    /**
     * Carbon helper
     *
     *
     * @return Carbon\Carbon
     *
     * @version 2.1
     */
    function carbon($time = null, $tz = null)
    {
        return app(\Carbon\Carbon::class, [$time, $tz]);
    }
}
