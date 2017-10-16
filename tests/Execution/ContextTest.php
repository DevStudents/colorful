<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Execution\Context;
use sintloer\COLORFUL\Http\Request;
use sintloer\COLORFUL\Nextines\Store;

class ContextTest extends TestCase
{

    private $_context;

    public function setUp()
    {
        $request = new Request();
        $this->_context = new Context($request);
    }

    public function testIsStoreAccess()
    {
        $this->assertEquals(Store::class, $this->_context->store);
    }
}
