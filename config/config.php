<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    |
    | You can add custom classes to your output, if need. More information
    | can be found in the Readme.md
    |
    */

    'styles' => [
        // 'default' => [
        //     'h1' => 'your-custom-classes',
        //     'a' => 'link',
        // ],
        // 'wiki' => [],
    ],

    /*
   |--------------------------------------------------------------------------
   | Settings
   |--------------------------------------------------------------------------
   |
   | Feel free to pass additional configuration options to the parser.
   |
   */

    'settings' => [
        'commonmark' => [
            // Check out the official docs for possible configuration options:
            // https://commonmark.thephpleague.com/1.6/configuration/

            // 'renderer' => [
            //     'block_separator' => "\n",
            //     'inner_separator' => "\n",
            //     'soft_break'      => "\n",
            // ],
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Images
   |--------------------------------------------------------------------------
   |
   | If fetching images from an external repository, you may wish to prefix
   | your image paths with a prefix to automatically convert a relative url
   | to an absolute url.
   |
   */
    'images' => [
        //  'prefix' => 'https://your-prefix.com/',
    ],
];
