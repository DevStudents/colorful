<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Http;

class Response
{

	/**
	 * Set HTTP response code.
	 * @param int $code
	 * 
	 */

	public function code($code)
	{
		http_response_code((int) $code);
	}

	/**
	 * Set HTTP response headers.
	 * @param string $name
	 * @param mixed $value
	 * 
	 */

	public function headers($name, $value = null)
	{
		if(is_array($name))
		{
			foreach($name as $key => $value)
				header($key . ': ' . $value);
		}

		header($name . ': ' . $value);
	}

	/**
	 * Display JSON data.
	 * @param array $data
	 * @param int $code (optional)
	 * @param string $type (optional)
	 * 
	 */

	public function json($data, $code = 200, $type = 'application/json')
	{
		if($code !== null)
			$this->code($code);

		$this->headers('Content-Type', $type);
		echo json_encode($data);
	}

	/**
	 * Display HTML.
	 * @param string $data
	 * @return boolean|null
	 * 
	 */

	public function display($str)
	{
		if($str !== false)
			echo $str;
	}

	/**
	 * Redirect response.
	 * @param string $url
	 * 
	 */

	public function redirect($url, $code = 303)
	{
		$this->code($code);
		$this->headers('Location', $url);
		exit();
	}

	/**
	 * Response error.
	 * @param string $msg
	 * @param int $code
	 * 
	 */

	public function error($msg, $code = 404)
	{
		$this->json([
				'error' => true,
				'message' => $msg
			], $code);
	}
}