<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Creation;

class CreationTest extends TestCase
{

	private $_creation;

	public function setUp()
	{
		$this->_creation = new Creation('DEVELOPMENT');
		$this->assertInternalType('string', $this->_creation::$ENV);
	}

	public function testEnvironmentModeIsValid()
	{
		$environmentModes = Creation::$ENVIRONMENT_MODES;
		$this->assertContains($this->_creation::$ENV, $environmentModes);
	}
}
