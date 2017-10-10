<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Router\Parser;
use sintloer\COLORFUL\Router\Route;
use sintloer\COLORFUL\Http\Request;
use sintloer\COLORFUL\Store\Routes;

class ParserTest extends TestCase
{

    public function testInvalidRun()
    {
        $return = Parser::run(new Request(), 'aaa');
        $this->assertFalse($return);
    }

    public function testValidRun()
    {
        Routes::add(
                new Route('GET', '/', function() {
                    return 1;
                })
            );

        $return = Parser::run(new Request('/', 'GET'), Routes::all());

        $isCallable = false;
        if(is_callable($return))
            $isCallable = true;

        $this->assertTrue($isCallable);
    }
}
