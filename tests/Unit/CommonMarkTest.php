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
</ul>
';

        $this->assertEquals($result, Markdown::parse($toParse));
    }

    /** @test */
    public function a_nested_tag_will_be_recognized()
    {
        config()->set('markdown.styles.default', ['li p' => 'text-sm']);

        $toParse = '<li><p>Some text</p></li>';
        $result = '<li><p class="text-sm">Some text</p></li>
';

        $this->assertEquals($result, Markdown::parse($toParse));
    }

    /** @test */
    public function a_nested_tag_with_text_inbetween_will_be_recognized()
    {
        config()->set('markdown.styles.default', ['a span' => 'text-red']);

        $toParse = '<a>Some <span>styled</span> text</a>';
        $result = '<p><a>Some <span class="text-red">styled</span> text</a></p>
';

        $this->assertEquals($result, Markdown::parse($toParse));
    }

    /** @test */
    public function a_nested_tag_with_text_inbetween_will_be_recognized_on_multilines_as_well()
    {
        config()->set('markdown.styles.default', ['li p' => 'text-bold']);

        $toParse = <<<'EOT'
                     <li>Bad formatted HTML
                        <p>Some more</p>
                     </li>
                     EOT;

        $result = <<<'EOT'
                  <li>Bad formatted HTML
                     <p class="text-bold">Some more</p>
                  </li>

                  EOT;

        $this->assertEquals($result, Markdown::parse($toParse));
    }

    /** @test */
    public function a_nested_tag_with_already_defined_classes_will_be_parsed_correctly()
    {
        config()->set('markdown.styles.default', ['a span' => 'text-red']);

        $toParse = '<a href="#">Some<span>thing</span></a>';
        $result = '<p><a href="#">Some<span class="text-red">thing</span></a></p>
';

        $this->assertEquals($result, Markdown::parse($toParse));
    }

    /** @test */
    public function a_nested_tag_will_be_replaced_and_wont_be_overwritten()
    {
        config()->set('markdown.styles.default', [
            'p'    => 'single',
            'li p' => 'nested',
        ]);

        $toParse = <<<'EOT'
                     <li>
                        <p>I am nested</p>
                     </li>
                     
                     <p>I am not</p>
                     EOT;

        $result = <<<'EOT'
                          <li>
                             <p class="nested">I am nested</p>
                          </li>
                          <p class="single">I am not</p>

                          EOT;

        $this->assertEquals($result, Markdown::parse($toParse));
    }

    /** @test */
    public function a_single_tag_will_not_replace_another_tag()
    {
        config()->set('markdown.styles.default', [
            'p'    => 'p-3',
            'pre'  => 'mb-4',
        ]);

        $toParse = <<<'EOT'
                     <p>
                         <pre>
                             <code>Amazing code</code>
                         </pre>
                     </p>
                     EOT;

        $result = <<<'EOT'
                    <p class="p-3">
                        <pre class="mb-4">
                            <code>Amazing code</code>
                        </pre>
                    </p>

                    EOT;

        $this->assertEquals($result, Markdown::parse($toParse));
    }

    /** @test */
    public function it_prefixes_relative_image_sources()
    {
        config()->set('markdown.images.prefix', 'https://git.visuellverstehen.de/visuel/wiki/-/raw/main');
        $result = '<img src="/uploads/7a9a2cea1fe762a59ae72cb1fd78e7bd/screenshot_5.png" alt="screenshot_5" />';

        $prefixed = (new PrefixImageSources($result))->handle();
        $this->assertStringContainsString('src="https://git.visuellverstehen.de/visuel/wiki/-/raw/main/uploads/7a9a2cea1fe762a59ae72cb1fd78e7bd/screenshot_5.png"', $prefixed);
    }

    /** @test */
    public function it_does_not_prefix_if_config_empty()
    {
        $result = '<img src="/uploads/7a9a2cea1fe762a59ae72cb1fd78e7bd/screenshot_5.png" alt="screenshot_5" />';

        $prefixed = (new PrefixImageSources($result))->handle();
        $this->assertEquals($result, $prefixed);
    }

    /** @test */
    public function it_does_not_prefix_complete_urls()
    {
        config()->set('markdown.images.prefix', 'https://git.visuellverstehen.de/visuel/wiki/-/raw/main');
        $result = '<img src="https://www.visuellverstehen.de/fileadmin/_processed_/b/3/csm_frs-webapp-ui-ux-design-entwicklung-webbasierte-anwendung-digital-header-visuellverstehen-flensburg-werbeagentur-kommunikationsagentur-internetagentur_7b5cbde98a.jpg" alt="screenshot_5" />';

        $prefixed = (new PrefixImageSources($result))->handle();
        $this->assertStringNotContainsString('https://git.visuellverstehen.de/visuel/wiki/-/raw/main', $prefixed);
    }
}
