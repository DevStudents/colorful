<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Store\Before;

class BeforeTest extends TestCase
{

    public function testHasCallbackBeforeSet()
    {
        $this->assertFalse(Before::has());
    }

    public function testAddCallback()
    {
        $return = Before::set(function () {
                return 1;
            });

        $this->assertTrue($return);
    }

    public function testGetCallback()
    {
        $return = Before::get();

        $isCallable = false;
        if(is_callable($return))
            $isCallable = true;

        $this->assertTrue($isCallable);
    }

    public function testHasCallbackAfterSet()
    {
        $this->assertTrue(Before::has());
    }
}
