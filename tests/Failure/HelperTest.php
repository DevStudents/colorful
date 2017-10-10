<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Failure\Helper;
use sintloer\COLORFUL\Creation;

class HelperTest extends TestCase
{

    public function testInvalidLoad()
    {
        $return = Helper::load(100, 'asdasd');
        $this->assertEquals('None for this failure.', $return);
    }

    public function testValidLoad()
    {
        $return = Helper::load(1001, [
            'modes' => Creation::$ENVIRONMENT_MODES
        ]);

        $this->assertNotEquals('None for this failure.', $return);
        $this->assertInternalType('string', $return);
    }
}
