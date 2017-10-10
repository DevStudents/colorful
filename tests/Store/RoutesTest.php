<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Store\Routes;
use sintloer\COLORFUL\Router\Route;

class RoutesTest extends TestCase
{

    public function testAddNewRoute()
    {
        $return = Routes::add(
                new Route('GET', '/', function ($request, $response) {
                        return 1;
                    })
            );

        $this->assertTrue($return);
    }

    public function testGetAllRoutes()
    {
        $return = Routes::all();
        $this->assertInternalType('array', $return);
    }
}
