# Markdown to HTML

## Installation
`composer require visuellverstehen/markdown-to-html`

## Usage

There might be cases, if for example using [TailwindCss](https://tailwindcss.com), where you want to use custom classes to style your output.

### Getting started
```php
use VV\Markdown\Facades\Markdown;

Markdown::parse($yourContent); // The outpul will be HTML
```

### Configuration
To add or change style sets, simply add or change an array with classes that should be added to the HTML tag.
```php
'default' => [
    'h1' => 'text-2xl',
    'a'  => 'link hover:text-blue',
    'p' => 'mb-5',
    'li p' => 'mb-2 ml-4',
],
```
*This example uses TailwindCSS, but you can use whatever kind of CSS you want.*

### Example Output
```html
<h1 class="text-2xl">A headline</h1>
<p class="mb-5">Some text</p>

<ul>
    <li><p class="mb-2 ml-4">A list item</p></li>
    <li><p class="mb-2 ml-4">A list item</p></li>
    <li><p class="mb-2 ml-4"><a class="link hover:text-blue" href="#">Klick me</a></p></li>
</ul>

<p class="mb-5">Another text</p>
```

#### Multiple styles
Define multiple styles in your config, so you can switch between them and use different stylings in different places of your application. 

```php 
// config/markdown.php
'styles' => [
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
