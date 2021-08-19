<?php

namespace VV\Markdown\Markdown;

use League\CommonMark\GithubFlavoredMarkdownConverter;

class CommonMarkRepository implements MarkdownRepository
{
    public GithubFlavoredMarkdownConverter $parser;

    public string $style = 'default';

    public function __construct(array $config)
    {
        $this->parser = new GithubFlavoredMarkdownConverter($config);
    }

    public function parse(string $content): string
    {
        $content = $this->parser->convertToHtml($content);
        $content =  (new PrefixImageSources($content))->handle();

        return (new AddCustomHtmlClasses($content, $this->style))->handle();
    }

    public function style(string $style): self
    {
        $this->style = $style;

        return $this;
    }
}
