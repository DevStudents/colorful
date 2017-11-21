<?php

/**
 * COLORFULframework
 * @author sintloer <contact@sintloer.com>
 * @license MIT
 *
 */

namespace sintloer\COLORFUL\Http;
use sintloer\COLORFUL\Router;

class Request
{

	/**
	 * Action storage.
	 * @var string
	 *
	 */

	private $_action;

	/**
	 * Method storage.
	 * @var string
	 *
	 */

	private $_method;

	/**
	 * Input storage.
	 * @var array
	 *
	 */

	private $_input;

	/**
	 * Params storage.
	 * @var array
	 *
	 */

	public $params = [];

	/**
	 * Constructor.
	 *
	 */

	public function __construct($action = '', $method = '', $input = [])
	{
		if(!empty($action))
			$this->_action = $action;
		else
			$this->_action = '/' . (isset($_GET['_cfACTION']) ? $_GET['_cfACTION'] : '');

		if(!empty($method))
			$this->_method = $method;
		else
			$this->_method = strtoupper((isset($_GET['_method']) ? $_GET['_method'] : (isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '')));

		if(is_array($input) && count($input) > 0)
			$this->_input = $input;
		else
			$this->_input = @json_decode(file_get_contents('php://input'), true);

		if(!is_array($this->_input))
			$this->_input = [];
	}

	/**
	 * Get current action.
	 * @return string
	 *
	 */

	public function action()
	{
		return $this->_action;
	}

	/**
	 * Get method.
	 * @return string
	 *
	 */

	public function method()
	{
		return $this->_method;
	}

	/**
	 * Get parameter.
	 * @param string $name
	 * @param string $defaultValue (optional)
	 * @return mixed
	 *
	 */

	public function param($name, $defaultValue = '')
	{
		if(isset($this->params[$name]) && !empty($this->params[$name]))
			return $this->params[$name];

		return $defaultValue;
	}

	/**
	 * Get input field.
	 * @param string name
	 * @param mixed $defaultValue (optional)
	 * @return mixed
	 *
	 */

	public function input($name, $defaultValue = false)
	{
		if(isset($this->_input[$name]) && !empty($this->_input[$name]))
			return $this->_input[$name];
		else if(isset($_GET[$name]) && !empty($_GET[$name]))
			return $_GET[$name];
		else if(isset($_POST[$name]) && !empty($_POST[$name]))
			return $_POST[$name];
		else if(isset($_FILES[$name]) && !empty($_FILES[$name]))
			return $_FILES[$name];

		return $defaultValue;
	}

	/**
	 * Get header parameter.
	 * @param string $name
	 * @return mixed
	 *
	 */

	public function header($name)
	{
		if(isset($_SERVER['HTTP_' . $name]))
			return $_SERVER['HTTP_' . $name];

		return false;
	}
}
