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
                'View About Us section to see all Member perks',
                'Access to member-only content',
                'Member badge next to your name',
                'Custom emoji',
            ]
        ],
        [
            'name' => 'Premium',
            'stripe_id' => 'price_1LgbhLHrjW9mNEkbLKo7f1tr',
            'price' => 59.99,
            'description' => 'Just a premium plan',
            'features' => [
                'All perks from previous plans',
                'Free membership to gift to someone else',
            ]
        ],
    ]

];
