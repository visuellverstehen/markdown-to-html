<?php

namespace VV\Markdown\Tests\Unit;

use VV\Markdown\Facades\Markdown;
use VV\Markdown\Tests\TestCase;

class CommonMarkTest extends TestCase
{
    /** @test */
    public function a_headline_will_be_converted_correctly()
    {
        $toParse = '# Hello World!';
        $result = '<h1>Hello World!</h1>';

        $this->assertStringcontainsString($result, Markdown::parse($toParse));
    }
}
