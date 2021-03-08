<?php

namespace VV\Markdown\Markdown;

use League\CommonMark\CommonMarkConverter;

class CommonMarkRepository implements MarkdownRepository
{
    public CommonMarkConverter $parser;
    public string $style = 'default';

    public function __construct(array $config)
    {
        $this->parser = new CommonMarkConverter($config);
    }

    public function parse(string $content): string
    {
        $content = $this->parser->convertToHtml($content);

        return (new addCustomHtmlClasses($content, $this->style))->handle();
    }

    public function style(string $style): self
    {
        return $this;
    }
}
