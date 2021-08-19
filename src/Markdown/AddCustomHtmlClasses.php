<?php

namespace VV\Markdown\Markdown;

class AddCustomHtmlClasses
{
    public string $content;
    public string $style;
    public array $styleSet;

    public function __construct(string $content, string $style)
    {
        $this->content = $content;
        $this->style = $style;
        $this->styleSet = $this->getStyleSet();
    }

    /**
     * Loop through the rendered html to inject our custom css classes by replacing basic html-tags which
     * will be enriched with our custom css classes and replaced.
     */
    public function handle(): string
    {
        $tags = collect($this->getStyleSet())
            ->map(fn ($classes, $tags) => new Tag($tags, $classes))
            ->sortByDesc('count');

        $tags->each(function ($tag) {
            $this->content = $this->parse($tag, $this->content);
        });

        return $this->content;
    }

    public function parse(Tag $tag, string $value): string
    {
        return preg_replace(
            $this->defineRegexPattern($tag),
            $this->defineReplacement($tag),
            $value
        );
    }

    private function defineRegexPattern(Tag $tag): string
    {
        $pattern = '';

        foreach ($tag->before as $name) {
            $pattern .= "<{$name}[^>]*>[^<]*";
        }

        return "/({$pattern})(<{$tag->tag})(?! class)/iU";
    }

    private function defineReplacement(Tag $tag): string
    {
        return "$1<{$tag->tag} class=\"{$tag->classes}\"";
    }

    private function getStyleSet(): array
    {
        $configPath = 'markdown.styles.'.$this->style;

        return config($configPath, []);
    }
}
