<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Http\Response;

class ResponseTest extends TestCase
{

    private $_response;

    public function setUp()
    {
        $this->_response = new Response();
    }

    public function testHttpCodeIsChanged()
    {
        $code = $this->_response->code(202);
        $this->assertEquals(202, $code);
    }

    public function testResponseByJson()
    {
        $data = [
            'test' => 10,
            'test2' => 20
        ];

        $this->_response->json($data);
        $this->assertEquals(json_encode($data), ob_get_contents());
    }

    public function testErrorResponseByJson()
    {
        $this->_response->error('Any message...');
        $this->assertEquals(true, (json_decode(ob_get_contents(), true))['error']);
    }

    public function testResponseByDisplay()
    {
        $text = $this->_response->display('text');
        $this->assertEquals('text', ob_get_contents());
    }
}
