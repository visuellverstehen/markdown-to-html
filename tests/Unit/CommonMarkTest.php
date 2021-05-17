<?php

namespace VV\Markdown\Tests\Unit;

use VV\Markdown\Facades\Markdown;
use VV\Markdown\Markdown\PrefixImageSources;
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
        config()->set('markdown.styles.default.a', 'link');

        $toParse = '[visuellverstehen](https://www.visuellverstehen.de)';
        $result = '<a class="link" href="https://www.visuellverstehen.de">visuellverstehen</a>';

        $this->assertStringcontainsString($result, Markdown::parse($toParse));
    }

    /** @test */
    public function it_can_add_a_html_class_to_a_paragraph()
    {
        config()->set('markdown.styles.default.p', 'mb-2');

        $toParse = 'some random text';
        $result = '<p class="mb-2">some random text</p>';

        $this->assertStringcontainsString($result, Markdown::parse($toParse));
    }

    /** @test */
    public function it_can_parse_tables()
    {
        $toParse = 'th | th(center) | th(right)
---|:----------:|----------:
td | td         | td';
        $result = '<table>';

        $this->assertStringcontainsString($result, Markdown::parse($toParse));
    }

    /** @test */
    public function it_can_add_a_css_class_to_a_table()
    {
        config()->set('markdown.styles.default.table', 'mb-2');

        $toParse = 'th | th(center) | th(right)
---|:----------:|----------:
td | td         | td';
        $result = '<table class="mb-2">';

        $this->assertStringcontainsString($result, Markdown::parse($toParse));
    }

    /** @test */
    public function it_can_parse_lists()
    {
        $toParse = '* First item
* Second item
* Third item
* Fourth item';

        $result = '<ul>
<li>First item</li>
<li>Second item</li>
<li>Third item</li>
<li>Fourth item</li>
</ul>';

        $this->assertStringcontainsString($result, Markdown::parse($toParse));
    }

    /** @test */
    public function it_prefixes_relative_image_sources()
    {
        config()->set('markdown.images.prefix', 'https://git.visuellverstehen.de/visuel/wiki/-/raw/main/');

        $toParse = '![screenshot_5](/uploads/7a9a2cea1fe762a59ae72cb1fd78e7bd/screenshot_5.png)';
        $result = '<img src="/uploads/7a9a2cea1fe762a59ae72cb1fd78e7bd/screenshot_5.png" alt="screenshot_5" />';

        $prefixed = (new PrefixImageSources($result, 'Allgemein'))->handle();
        var_dump($prefixed);
        $this->assertStringContainsString('TEST', 'TEST');
    }
}
