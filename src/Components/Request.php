<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Components;
use sintloer\COLORFUL\Core;

/**
 * Request component.
 * 
 */

class Request
{

	/**
	 * Get input from Request class.
	 * @return array
	 * 
	 */

	public static function input()
	{
		return Core\Request::getInput();
	}
}