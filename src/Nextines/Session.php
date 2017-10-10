<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Nextines;

class Session extends Nextine
{

	/**
	 * Start session.
	 * @param mixed $name (optional)
	 * @param mixed $id (optional)
	 *
	 */

	public static function start($name = null, $id = null)
	{
		if(gettype($name) === 'string')
			session_name($name);

		if(gettype($id) === 'string')
		{
			if(!Cookie::has($name))
				session_id($id);
		}

		@session_start();
	}

	/**
	 * Set session.
	 * @param string $name
	 * @param mixed $value (optional)
	 * @return mixed
	 *
	 */

	public static function set($name, $value = null)
	{
		if(is_array($name))
		{
			foreach($name as $key => $value)
				$_SESSION[$key] = $value;

			return;
		}

		$_SESSION[$name] = $value;
	}

	/**
	 * Get session key.
	 * @param string $name
	 * @return mixed
	 *
	 */

	public static function get($name)
	{
		if(self::has($name))
			return $_SESSION[$name];

		return false;
	}

	/**
	 * Remove session value by key.
	 * @param string $name
	 * @return boolean
	 *
	 */

	public static function remove($name)
	{
		if(self::has($name))
			unset($_SESSION[$name]);

		return false;
	}

	/**
	 * Check if session key exists.
	 * @param string $name
	 * @return boolean
	 *
	 */

	public static function has($name)
	{
		if(isset($_SESSION[$name]))
			return true;

		return false;
	}

	/**
	 * Session destroy method.
	 *
	 */

	public static function destroy()
	{
		@session_unset();
		@session_destroy();
		$_SESSION = [];
	}
}
