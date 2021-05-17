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
     * Loop through the rendered html to inject our custom css classes by replacing basic html-tags which
     * will be enriched with our custom css classes and replaced.
     */
    public function handle()
    {
        $this->findImageSources($this->findImages($this->content));

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


    public function findImageSources(array $htmlImages): void
    {
        $result = [];
        foreach($htmlImages as $image)
        {
            preg_match_all('/(src)=("[^"]*")/i',$image, $sources);
            $source = collect($sources)->flatten()->toArray()[0];
            if ($source) {
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

    public function getPrefixUrl(): string
    {
        $configPrefix = 'markdown.images.prefix';

        if (!config()->has($configPrefix)) {
            return '';
        }

        return config($configPrefix) . $this->category;
    }
}
