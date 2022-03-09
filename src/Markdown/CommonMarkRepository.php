<?php

namespace VV\Markdown\Markdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\MarkdownConverter;

class CommonMarkRepository implements MarkdownRepository
{
    public MarkdownConverter $parser;

    public string $style = 'default';

    public function __construct(array $config)
    {
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        if (key($config) === "external_link") {
            $environment->addExtension(new ExternalLinkExtension());
        }

        $this->parser = new MarkdownConverter($environment);
    }

    public function parse(string $content): string
    {
        $content = $this->parser->convertToHtml($content);
        $content = (new PrefixImageSources($content))->handle();

        return (new AddCustomHtmlClasses($content, $this->style))->handle();
    }

    public function style(string $style): self
    {
        $this->style = $style;

        return $this;
    }
}
