<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Execution\Runner;

class RunnerTest extends TestCase
{

    public function testIsNotExecuted()
    {
        $this->assertFalse(Runner::executed());
    }

    public function testIsExecuted()
    {
        Runner::start();
        $this->assertTrue(Runner::executed());
    }
}
