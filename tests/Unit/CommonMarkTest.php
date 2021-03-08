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

    /** @test */
    public function it_can_add_a_html_class_to_a_link()
    {
        config()->set('markdown.classes.default.a', 'link');

        $toParse = '[visuellverstehen](https://www.visuellverstehen.de)';
        $result = '<a class="link" href="https://www.visuellverstehen.de">visuellverstehen</a>';

        $this->assertStringcontainsString($result, Markdown::parse($toParse));
    }

    /** @test */
    public function it_can_add_a_html_class_to_a_paragraph()
    {
        config()->set('markdown.classes.default.p', 'mb-2');

        $toParse = 'some random text';
        $result = '<p class="mb-2">some random text</p>';

        $this->assertStringcontainsString($result, Markdown::parse($toParse));
    }
}
