<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Nextines;

class Store extends Nextine
{

	/**
	 * Data storage.
	 * @var array
	 *
	 */

    private static $_data = [];

    /**
     * Save object to store.
     * @param mixed $name
     * @param mixed $value (optional)
     *
     */

    public static function save($name, $value = null)
    {
        if(is_array($name) && $value === null)
        {
            foreach($name as $key => $value)
            {
                if(is_callable($value))
                    self::$_data[$key] = $value();
                else
                    self::$_data[$key] = $value;
            }

            return;
        }

        if(is_callable($value))
            self::$_data[$key] = $value();
        else
            self::$_data[$key] = $value;
    }

    /**
     * Get object from store.
     * @param string $name
     * @return mixed
     *
     */

    public static function get($name)
    {
        if(self::has($name))
            return self::$_data[$name];

        return false;
    }

    /**
     * Check if exists object in store.
     * @param string $name
     * @return boolean
     *
     */

    public static function has($name)
    {
        return isset(self::$_data[$name]);
    }
}
