<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Nextines\Session;

class SessionTest extends TestCase
{

    public function setUp()
    {
        Session::start();
        Session::set('test', 'value');
    }

    public function testSessionIsStarted()
    {
        $this->assertNotEquals(session_id(), '');
    }

    public function testGetIsWorking()
    {
        $get = Session::get('test');
        $this->assertInternalType('string', $get);
        $this->assertEquals('value', $get);
    }

    public function testIsSessionDestroyed()
    {
        Session::destroy();
        $this->assertEquals([], $_SESSION);
    }
}
