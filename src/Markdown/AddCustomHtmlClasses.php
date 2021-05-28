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
        foreach ($this->styleSet as $tag => $class) {
            $this->content = str_replace($this->tagFilter($tag), $this->replaceTag($tag, $class), $this->content);
        }

        return $this->content;
    }

    /**
     * Build the string we want to replace.
     */
    private function tagFilter(string $tag): string
    {
        return "<{$tag}";
    }

    /**
     * Replace the filtered tag and add custom css classes.
     */
    private function replaceTag(string $tag, string $class): string
    {
        return "<{$tag} class=\"{$class}\"";
    }

    private function getStyleSet(): array
    {
        $configPath = 'markdown.styles.'.$this->style;

        return config($configPath, []);
    }
}
