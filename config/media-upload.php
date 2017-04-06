<?php

/*
 |--------------------------------------------------------------------------
 | Upload Types
 |--------------------------------------------------------------------------
 |
 | It's the flexibility of this package. You can define the type of upload
 | file methods. For example, you want to upload for profile picture,
 | article post, background, etc. Here is 
 |
 */
return [
'types' => [
    // ... put your custom type ...

    'profile' => [
        'middleware' => 'auth',
        'format' => 'image',
        'image' => [
            'fit' => [400, 400],
            'thumbs' => [
                'small' => [50, 50],
                'medium' => [100, 100],
            ]
        ],
        'save_original' => true,
    ],

    'profile-cover' => [
        'middleware' => 'auth',
        'format' => 'image',
        'image' => [
            'fit' => [1200, 400],
        ],
        'multiple' => false,
    ],

    'media' => [
        'middleware' => 'auth',
        'format' => 'image|video|audio',
        'image' => [
            'thumbs' => [
                'small' => [50, 50],
                'medium' => [100, 100],
            ]
        ],
        'multiple' => true,
    ],

], 

]; 