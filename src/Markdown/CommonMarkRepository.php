<?php

namespace VV\Markdown\Markdown;

use League\CommonMark\CommonMarkConverter;

class CommonMarkRepository implements MarkdownRepository
{
    public CommonMarkConverter $parser;

    public function __construct(array $config)
    {
        $this->parser = new CommonMarkConverter($config);
    }

    public function parse(string $content): string
    {
        return $this->parser->convertToHtml($content);
    }
}
