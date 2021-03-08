# Markdown to HTML

## Installation
`composer require visuellverstehen/markdown-to-html`

## Usage

### Getting started
```php
use VV\Markdown\Facades\Markdown;

Markdown::parse($yourContent); // The outpul will be HTML
```

### Output styling

#### Basic
You can always format your markdown by using a wrapper of some kind. 
```css
.markdown h1 {
    font-weight: bold;
    ...
} 
```

```html
<div class="markdown">
    <!-- Auto generated output -->
    <h1>Headline</h1>
    <p>Some text</p>
</div>
```

### Custom classes
There might be cases, if for example using [TailwindCss](https://tailwindcss.com), where you want to use custom classes to style your output. 

```php 
// config/markdown.php
'style' => [
    'default' => [
        'h1' => 'text-2xl',
        'p' => 'mb-2',
    ],
    ...
```

The output would look like this
```html
<h1 class="text-2xl">Headline</h1>
<p class="mb-2">Some text</p>
```

#### Multiple styles
Define multiple styles in your config, so you can switch between them and use different stylings in different places of your application. 

```php 
// config/markdown.php
'style' => [
    'default' => [
        'h1' => 'text-2xl',
        'p' => 'mb-2',
    ],
    'wiki' => [
        'h1' => 'text-4xl',
        'p' => 'mb-8',
    ],
    ...
```

Define `style` to switch between styles. 
```php 
Markdown::style('wiki')->parse($yourContent);
```

No need to define default. If nothing has been provied, markdown will look for the default style.



# More about us
- [www.visuellverstehen.de](https://visuellverstehen.de)

# License
The MIT License (MIT). Please take a look at our [License File](LICENSE.md) for more information.
