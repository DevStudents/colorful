<?php

/**
 * COLORFULframework
 * @author sintloer <me@sintloer.com>
 * @license MIT
 * 
 */

namespace sintloer\COLORFUL\Core;
use sintloer\COLORFUL\Core\Http\Request;

/**
 * Initialize class.
 * 
 */

class Initialize
{

	/**
	 * Constructor of Initialize class.
	 * @param string $mode
	 * @return void
	 * 
	 */

	public function __construct($mode)
	{
		$this->_env($mode);
		$this->_runCOLORFUL();
	}

	/**
	 * Set environment mode.
	 * @return void
	 * 
	 */
	
	private function _env($mode)
	{
		$env = ['DEVELOPMENT', 'PRODUCTION'];

		if(!in_array($mode, $env))
			Error::show('You need to configure ENV.', 1001, [
					'env' => $env
				]);

		switch($mode)
		{
			case 'DEVELOPMENT':
				error_reporting(E_ALL);
				break;

			case 'PRODUCTION':
				error_reporting(0);
				break;
		}
	}

	/**
	 * Constructor of Initialize class.
	 * @return void
	 * 
	 */
	
	private function _runCOLORFUL()
	{
		new Executor(
				new Request(),
				new Router()
			);
	}
}