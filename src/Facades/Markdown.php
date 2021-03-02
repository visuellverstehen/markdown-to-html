<?php

namespace VV\Markdown\Facades;

use Illuminate\Support\Facades\Facade;
use VV\Markdown\Markdown\MarkdownRepository;

class Markdown extends Facade
{
    /**
     * @method static mixed parse($content)
     *
     * @see \VV\Markdown\CommonMarkRepository
     */
    protected static function getFacadeAccessor()
    {
        return MarkdownRepository::class;
    }
}
