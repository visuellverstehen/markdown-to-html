<?php

namespace VV\Markdown\Tests\Unit;

use VV\Markdown\Facades\Markdown;
use VV\Markdown\Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function a_singletag_will_be_extended_with_the_given_class_names()
    {
        $this->assertEquals('test', Markdown::parse('test'));
    }
}
