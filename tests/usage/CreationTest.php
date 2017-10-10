<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Creation;

class CreationTest extends TestCase
{

	private $_creation;

	public function setUp()
	{
		$this->_creation = new Creation('DEVELOPMENT');
	}

	public function testEnvironmentModeIsStringType()
	{
		$this->assertInternalType('string', $this->_creation::$ENV);
	}

	public function testEnvironmentModeIsValid()
	{
		$environmentModes = Creation::$ENVIRONMENT_MODES;
		$this->assertContains($this->_creation::$ENV, $environmentModes);
	}

	public function testSetInvalidBeforeMethodCallback()
	{
		$return = $this->_creation->before('str');
		$this->assertFalse($return);
	}

	public function testSetValidBeforeMethodCallback()
	{
		$return = $this->_creation->before(function ($request, $response) {
			return 1;
		});

		$this->assertInstanceOf(Creation::class, $return);
	}

	public function testSetInvalidAfterMethodCallback()
	{
		$return = $this->_creation->after('str');
		$this->assertFalse($return);
	}

	public function testSetValidAfterMethodCallback()
	{
		$return = $this->_creation->after(function ($request, $response) {
			return 1;
		});

		$this->assertInstanceOf(Creation::class, $return);
	}

	public function testUseInvalidWhenMethod()
	{
		$return = $this->_creation->when('');
		$this->assertFalse($return);
	}

	public function testUseValidWhenMethod()
	{
		$return = $this->_creation->when('simple', function($request, $response) {
				return 1;
			});

		$this->assertInstanceOf(Creation::class, $return);
	}

	public function testUseInvalidWhenMethodByArray()
	{
		$return = $this->_creation->when([
				'test1' => function() {
					return 1;
				},
				'test2' => 'asdasd'
			]);

		$this->assertFalse($return);
	}

	public function testUseValidWhenMethodByArray()
	{
		$return = $this->_creation->when([
				'test1' => function() {
					return 1;
				},
				'test2' => function() {
					return 2;
				}
			]);

		$this->assertInstanceOf(Creation::class, $return);
	}

	public function testUseInvalidRoutesMethod()
	{
		$return = $this->_creation->routes([
				'GET' => [
					'/' => 'test'
				]
			]);

		$this->assertFalse($return);
	}

	public function testUseValidRoutesMethod()
	{
		$return = $this->_creation->routes([
				'GET' => [
					'/' => function ($request, $response) {
						return 1;
					}
				]
			]);

		$this->assertInstanceOf(Creation::class, $return);
	}

	public function testAddInvalidRouteBySimpleMethod()
	{
		$return = $this->_creation->get('/', 'asdasd');
		$this->assertFalse($return);
	}

	public function testAddValidRouteBySimpleMethod()
	{
		$return = $this->_creation->get('/', function($request, $response) {
				return 1;
			});

		$this->assertInstanceOf(Creation::class, $return);
	}
}
