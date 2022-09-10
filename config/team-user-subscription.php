<?php

return [

    'application_fee_percent' => 10,

    'plans' => [
        [
            'name' => 'Basic',
            'stripe_id' => 'price_1I1E7KFEoHB9qGEvEh5v6YWR',
            'price' => 29.99,
            'description' => 'Just a basic plan',
            'features' => [
                'Feature 1',
                'Feature 2',
            ]
        ],
        [
            'name' => 'Premium',
            'stripe_id' => 'price_1I1E7oFEoHB9qGEvXsKyuvYw',
            'price' => 59.99,
            'description' => 'Just a premium plan',
            'features' => [
                'Feature 1',
                'Feature 2',
            ]
        ],
    ]

];
