<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Event\Caller;
use sintloer\COLORFUL\Http\Request;
use sintloer\COLORFUL\Http\Response;
use sintloer\COLORFUL\Execution\Context;

class CallerTest extends TestCase
{

    public function testInvalidInit()
    {
        $init = Caller::init('aaa', 'asd');
        $this->assertFalse($init);
    }

    public function testValidInit()
    {
        $request = new Request();
        $init = Caller::init([
            'aaaa' => function() {
                return 100;
            }
        ], [ $request, new Response(), new Context($request) ]);

        $this->assertNull($init);
    }

    public function testRunInvalidListener()
    {
        $return = Caller::run('a');
        $this->assertFalse($return);
    }

    public function testRunValidListener()
    {
        $return = Caller::run('aaaa');
        $this->assertTrue($return);
    }
}
