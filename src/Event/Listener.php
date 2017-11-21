<?php

/**
 * COLORFULframework
 * @author sintloer <contact@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Event;
use Closure;

class Listener
{

	/**
	 * Listener name.
	 * @var string
	 * 
	 */
	
	private $_name;

	/**
	 * Listener callback.
	 * @var Closure
	 * 
	 */
	
	private $_callback;

	/**
	 * Constructor.
	 * @param string $name
	 * @param Closure $callback
	 * 
	 */
	
	public function __construct($name, Closure $callback)
	{
		$this->_name = $name;
		$this->_callback = $callback;
	}

	/**
	 * Get name.
	 * @return string
	 * 
	 */

	public function getName()
	{
		return $this->_name;
	}

	/**
	 * Get callback.
	 * @return Closure
	 * 
	 */

	public function getCallback()
	{
		return $this->_callback;
	}
}