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

    public function parse(string $content, string $page = ''): string
    {
        $content = $this->parser->convertToHtml($content);

        return (new PrefixImageSources(
            (new AddCustomHtmlClasses($content, $this->style))->handle(),
            $page)
        )->handle();
    }

    public function style(string $style): self
    {
        return $this;
    }
}
