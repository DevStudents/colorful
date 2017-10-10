<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Store\After;

class AfterTest extends TestCase
{

    public function testHasCallbackBeforeSet()
    {
        $this->assertFalse(After::has());
    }

    public function testAddCallback()
    {
        $return = After::set(function () {
                return 1;
            });

        $this->assertTrue($return);
    }

    public function testGetCallback()
    {
        $return = After::get();

        $isCallable = false;
        if(is_callable($return))
            $isCallable = true;

        $this->assertTrue($isCallable);
    }

    public function testHasCallbackAfterSet()
    {
        $this->assertTrue(After::has());
    }
}
