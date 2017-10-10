<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Failure\Message;
use sintloer\COLORFUL\Creation;

class MessageTest extends TestCase
{

    public function testHasBeforeShow()
    {
        $this->assertFalse(Message::has());
    }

    public function testShow()
    {
        $return = Message::show('Message...', 1001, [
            'modes' => Creation::$ENVIRONMENT_MODES
        ]);

        $this->assertFalse($return);
    }

    public function testHasAfterShow()
    {
        $this->assertTrue(Message::has());
    }
}
