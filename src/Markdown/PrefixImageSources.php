<?php

namespace VV\Markdown\Markdown;

use Illuminate\Support\Str;

class PrefixImageSources
{
    public string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Find all image sources in the html content and replace all absolute paths with a configurable url that is prefixed to it.
     */
    public function handle()
    {
        if ($this->getPrefixUrl()) {
            $this->findImageSources($this->findImages($this->content));
        }

        return $this->content;
    }

    /**
     * Iterate over the html and find all images.
     */
    private function findImages(string $htmlContent): array
    {
        preg_match_all('/<img[^>]+>/i', $htmlContent, $result);

        return collect($result)->flatten()->toArray();
    }

    /**
     * Iterate over all sources and prefix them with the configurable url.
     */
    private function findImageSources(array $htmlImages): void
    {
        foreach ($htmlImages as $image) {
            preg_match('/src=(?:"[^"]*")/i', $image, $source);

            $source = $source[0] ?? null;

            if ($source && !$this->isAbsolutePath($source)) {
                $this->content = str_replace($source, $this->insertPrefix($source), $this->content);
            }
        }
    }

    /**
     * Add prefix to image source.
     */
    private function insertPrefix(string $source): string
    {
        $source = str_replace('src="', '', $source);

        if (Str::startsWith($source, '/')) {
            $source = Str::substr($source, 1);
        }

        $prefix = $this->getPrefixUrl();

        return 'src="'.$prefix.$source;
    }

    /**
     * Load Prefix URL from config.
     */
    private function getPrefixUrl(): ?string
    {
        $prefix = config('markdown.images.prefix', null);

        if ($prefix) {
            $prefix = Str::finish($prefix, '/');
        }

        return $prefix;
    }

    /**
     * Check if source is a absolute path or a complete url.
     */
    private function isAbsolutePath(string $source): bool
    {
        return $this->string_contains($source, 'https://')
        || $this->string_contains($source, 'http://')
        || $this->string_contains($source, 'ftp://');
    }

    /**
     * Helper function for php versions that do not support str_contains.
     */
    private function string_contains($haystack, $needle): bool
    {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}
