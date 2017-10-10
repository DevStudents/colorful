<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Nextines\Store;

class StoreTest extends TestCase
{

    public function setUp()
    {
        Store::save([
            'number' => 4,
            'closure' => function() {
                return 'text';
            }
        ]);
    }

    public function testIsReturningNumber()
    {
        $this->assertInternalType('int', Store::get('number'));
    }

    public function testIsReturningStringByClosure()
    {
        $this->assertInternalType('string', Store::get('closure'));
    }
}
