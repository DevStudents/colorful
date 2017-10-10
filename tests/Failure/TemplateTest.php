<?php

use PHPUnit\Framework\TestCase;
use sintloer\COLORFUL\Failure\Template;

class TemplateTest extends TestCase
{

    public function testDisplay()
    {
        $return = Template::display('Message', 1001, 'Test', 'Test');
        $this->assertTrue($return);
    }
}
