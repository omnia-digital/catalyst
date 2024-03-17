<?php

return [

    'tiptap' => [
        'toolbar' => [
            'enabled' => true,

            'items' => [
                'bold' => true,
                'italic' => true,
                'underline' => true,
                'strike' => true,
                'link' => true,
                'remove_link' => true,
                'image' => true,
                'code' => true,
                'heading_1' => true,
                'heading_2' => true,
                'heading_3' => true,
                'heading_4' => true,
                'bullet_list' => true,
                'ordered_list' => true,
                'task_list' => true,
                'code_block' => true,
                'table' => true,
                'align_left' => true,
                'align_center' => true,
                'align_right' => true,
                'align_justify' => true,
                'blockquote' => true,
                'horizontal_rule' => true,
                'line_break' => true,
                'clear_format' => true,
                'undo' => true,
                'redo' => true,
            ],
        ],

        'bubble_menu' => [
            'enabled' => true,
        ],

        'floating_menu' => [
            'enabled' => false,
        ],

        'external_links' => [
            'rel' => ['nofollow', 'noopener', 'noreferrer'],
        ],
    ],

    'place' => [
        'google' => [
            'api_key' => env('GOOGLE_PLACE_API_KEY'),
        ],

        'mapbox' => [
            'api_key' => env('MAPBOX_API_KEY'),
        ],
    ],

    'canva' => [
        'button' => [
            'api_key' => env('CANVA_BUTTON_API_KEY'),
        ],
    ],

];
