<?php

namespace VV\Markdown\Markdown;

interface MarkdownRepository
{
    public function __construct(array $config);

    public function parse($content): string;
}
