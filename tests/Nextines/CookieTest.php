<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Nextines\Cookie;

class CookieTest extends TestCase
{

    public function testSetInvalidCookie()
    {
        $_COOKIE['aaa'] = 100;
        $this->assertFalse(Cookie::get('test'));
    }

    public function testSetValidCookie()
    {
        $_COOKIE['test'] = 100;
        $this->assertEquals(100, Cookie::get('test'));
    }
}
