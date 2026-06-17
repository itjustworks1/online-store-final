<?php

return [
    'default_country' => 'global',

    'countries' => [
        'global' => [
            'label' => 'Any country',
            'dial_code' => null,
            'min_digits' => 10,
            'max_digits' => 15,
        ],
        'ru' => [
            'label' => 'Russia',
            'dial_code' => '+7',
            'min_digits' => 11,
            'max_digits' => 11,
        ],
        'us' => [
            'label' => 'United States',
            'dial_code' => '+1',
            'min_digits' => 10,
            'max_digits' => 10,
        ],
        'kz' => [
            'label' => 'Kazakhstan',
            'dial_code' => '+7',
            'min_digits' => 11,
            'max_digits' => 11,
        ],
        'by' => [
            'label' => 'Belarus',
            'dial_code' => '+375',
            'min_digits' => 12,
            'max_digits' => 12,
        ],
        'de' => [
            'label' => 'Germany',
            'dial_code' => '+49',
            'min_digits' => 11,
            'max_digits' => 13,
        ],
    ],
];
