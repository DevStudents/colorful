<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Failure;

class Reports
{

	/**
	 * Get Failure reports class name.
	 * @param array $trace
	 * @return string
	 * 
	 */
	
	public static function get($trace)
	{
		if(isset($trace[1]))
		{
			if(isset($trace[1]['class']) && !empty($trace[1]['class']))
				return $trace[1]['class'];
		}

		return 'Unknown';
	}
}