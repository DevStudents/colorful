<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Nextines;

abstract class Nextine
{

    /**
     * Config storage.
     * @var array
     *
     */

    private static $_config = [];

    /**
     * Set configuration method.
     * @param array $data (optional)
     *
     */

    public static function config($data = [])
    {
        if(count($data) == 0)
            return self::$_config;

        self::$_config = array_merge(self::$_config, $data);
    }
}
