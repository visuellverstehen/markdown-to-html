<?php

namespace VV\Markdown\Markdown;

class PrefixImageSources
{
    public string $content;
    public string $category;

    public function __construct(string $content, string $category)
    {
        $this->content = $content;
        $this->category = $category;
    }

    /**
     * Find all image sources in the html content
     * Replace all absolute paths with a configurable url that is prefixed to it
     */
    public function handle()
    {
        if ($this->getPrefixUrl()) {
            $this->findImageSources($this->findImages($this->content));
        }

        return $this->content;
    }

    /**
     * Iterate over the html and find all images
     */
    public function findImages(string $htmlContent): array
    {
        preg_match_all('/<img[^>]+>/i', $htmlContent, $result);

        return collect($result)->flatten()->toArray();
    }


    /**
     * Iterate over all sources and prefix them with the configurable url
     */
    public function findImageSources(array $htmlImages): void
    {
        $result = [];
        foreach($htmlImages as $image)
        {
            preg_match_all('/(src)=("[^"]*")/i',$image, $sources);
            $source = collect($sources)->flatten()->toArray()[0];
            if ($source && $this->isAbsolutePath($source)) {
                $result[] = $source;
                $this->content = str_replace($source ,$this->insertPrefix($source, $this->getPrefixUrl()), $this->content);
            }
        }
    }

    /**
     * Add prefix to image source
     */
    public function insertPrefix(string $source, string $prefix): string
    {
        $source = str_replace('src="', '', $source);
        return 'src="'. $prefix . $source;
    }

    /**
     * Load Prefix URL from config
     */
    public function getPrefixUrl(): ?string
    {
        $configPrefix = 'markdown.images.prefix';

        if (!config()->has($configPrefix)) {
            return null;
        }

        return config($configPrefix) . $this->category;
    }

    /**
     * Check if source is a absolute path or a complete url
     */
    private function isAbsolutePath(string $source): bool
    {
        return !str_contains($source, 'https://')
        && !str_contains($source, 'http://')
        && !str_contains($source, 'ftp://');
    }
}
