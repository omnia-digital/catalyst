<?php

return [

    'application_fee_percent' => 10,

    'plans' => [
        [
            'name' => 'Basic',
            'stripe_id' => 'price_1LgbhLHrjW9mNEkbUXYaSUFV',
            'price' => 29.99,
            'description' => 'Just a basic plan',
            'features' => [
                'Feature 1',
                'Feature 2',
            ]
        ],
        [
            'name' => 'Premium',
            'stripe_id' => 'price_1LgbhLHrjW9mNEkbLKo7f1tr',
            'price' => 59.99,
            'description' => 'Just a premium plan',
            'features' => [
                'Feature 1',
                'Feature 2',
            ]
        ],
    ]

];
