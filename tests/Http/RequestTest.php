<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Http\Request;

class RequestTest extends TestCase
{

    private $_request;

    public function setUp()
    {
        $this->_request = new Request();
    }

    public function testOfGettingParam()
    {
        $this->_request->params = [
            'test' => 'abcd'
        ];

        $param = $this->_request->param('test', 'default');
        $this->assertEquals('abcd', $param);
    }

    public function testOfGettingDefaultParam()
    {
        $param = $this->_request->param('hello', 'default');
        $this->assertEquals('default', $param);
    }

    public function testOfGettingInputValue()
    {
        $_GET = [];
        $_GET['aaa'] = 100;

        $input = $this->_request->input('aaa', 'default');
        $this->assertEquals(100, $input);
    }

    public function testOfGettingDefaultInputValue()
    {
        $input = $this->_request->input('hello', 'default');
        $this->assertEquals('default', $input);
    }

    public function testOfGettingHeaderValue()
    {
        $_SERVER['HTTP_TEST'] = 100;
        $header = $this->_request->header('TEST');
        $this->assertEquals(100, $header);
    }

    public function testOfGettingHeaderValueByEmpty()
    {
        $header = $this->_request->header('');
        $this->assertEquals(false, $header);
    }
}
