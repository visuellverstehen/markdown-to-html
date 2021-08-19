<?php

namespace VV\Markdown\Markdown;

class AddCustomHtmlClasses
{
    /**
     * The content the class will parse.
     */
    public string $content;

    /**
     * The chosen style which normaly would be `default`.
     */
    public string $style;

    /**
     * The belonging style stet as defined inside the config file.
     */
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
        // Fetching all style sets and ordering them after the count.
        $tags = collect($this->getStyleSet())
            ->map(fn ($classes, $tags) => new Tag($tags, $classes))
            ->sortByDesc('count');

        // Parse the content for every defined style set.
        $tags->each(function ($tag) {
            $this->content = $this->parse($tag, $this->content);
        });

        return $this->content;
    }

    /**
     * Is parsing the content and will add classes to the html-tags.
     */
    public function parse(Tag $tag, string $value): string
    {
        return preg_replace(
            $this->defineRegexPattern($tag),
            $this->defineReplacement($tag),
            $value
        );
    }

    /*
     * Defines the regex pattern and does take nested selectors into account.
     */
    private function defineRegexPattern(Tag $tag): string
    {
        $pattern = '';

        foreach ($tag->before as $name) {
            $pattern .= "<{$name}[^>]*>[^<]*";
        }

        return "/({$pattern})(<{$tag->tag})(?! class|\w)/iU";
    }

    /**
     * Does add the needed classes into the html tag.
     */
    private function defineReplacement(Tag $tag): string
    {
        return "$1<{$tag->tag} class=\"{$tag->classes}\"";
    }

    /**
     * Get the style sets from the config for the chosen style set.
     */
    private function getStyleSet(): array
    {
        $configPath = 'markdown.styles.'.$this->style;

        return config($configPath, []);
    }
}
