<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Store\Listeners;
use sintloer\COLORFUL\Event\Listener;

class ListenersTest extends TestCase
{

    public function testAddNewListener()
    {
        $return = Listeners::add(
                new Listener('test', function ($request, $response) {
                        return 1;
                    })
            );

        $this->assertTrue($return);
    }

    public function testGetAllListeners()
    {
        $return = Listeners::all();
        $this->assertInternalType('array', $return);
    }
}
