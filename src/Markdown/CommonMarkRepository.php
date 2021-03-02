<?php

namespace VV\Markdown\Markdown;

class CommonMarkRepository implements MarkdownRepository
{
    public function __construct(array $config)
    {
        //
    }

    public function parse($content): string
    {
        return $content;
    }
}
