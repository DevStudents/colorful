<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Failure\Reports;

class ReportsTest extends TestCase
{

    public function testGetInvalidReports()
    {
        $return = Reports::get('test');
        $this->assertEquals('Unknown', $return);
    }

    public function testGetValidReports()
    {
        $return = Reports::get(debug_backtrace());
        $this->assertNotEquals('Unknown', $return);
        $this->assertInternalType('string', $return);
    }
}
