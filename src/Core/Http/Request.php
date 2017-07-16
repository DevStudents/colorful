<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core\Http;

/**
 * Request class.
 * 
 */

class Request
{

	/**
	 * Request action.
	 * @var string
	 * 
	 */

	private $_action;

	/**
	 * Request action.
	 * @var string
	 * 
	 */

	private $_actionParts = [];

	/**
	 * Request method.
	 * @var string
	 * 
	 */

	private $_method;

	/**
	 * Constructor of Request class.
	 * 
	 */

	public function __construct()
	{
		$this->_action = $_GET['ACTION'] ?? null;
		$this->_method = $_SERVER['REQUEST_METHOD'];
		$this->_actionParts = explode('/', rtrim($this->_action, '/'));
	}

	/**
	 * Return action.
	 * @return string
	 * 
	 */

	public function getAction()
	{
		return $this->_action;
	}

	/**
	 * Return action.
	 * @return array
	 * 
	 */

	public function getActionParts()
	{
		return $this->_actionParts;
	}

	/**
	 * Get request method.
	 * @return string
	 * 
	 */

	public function getMethod()
	{
		return $this->_method;
	}

}