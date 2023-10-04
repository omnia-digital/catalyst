<?php

use OmniaDigital\CatalystCore\Facades\Translate;

return [
    'name' => 'Billing',

    'team_member_subscriptions' => [
        'application_fee_percent' => env('APPLICATION_FEE_PERCENT', 10),
        'plans' => [
            [
                'name' => 'Tier 1 Subscriber',
                'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_1_1_MONTH_PLAN_ID'),
                'price' => 4.99,
                'description' => Translate::get("Support every month and Subscribe to help the owner of this Team keep doing what they're doing"),
                'features' => [
                    'View About Us section to see all Member perks',
                    'Access to Sub-only content',
                    'Sub Badges next to your name',
                    'Custom emojis',
                ],
                'alternates' => [
                    [
                        'name' => 'Tier 1 Subscriber - 3 Months',
                        'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_1_3_MONTH_PLAN_ID'),
                        'price' => 14.97,
                        'description' => Translate::get('Renew every 3 months'),
                    ],
                    [
                        'name' => 'Tier 1 Subscriber - 6 Months',
                        'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_1_6_MONTH_PLAN_ID'),
                        'price' => 29.94,
                        'description' => Translate::get('Renew every 6 months'),
                    ],
                ],
            ],
            [
                'name' => 'Tier 2 Subscriber',
                'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_2_1_MONTH_PLAN_ID'),
                'price' => 9.99,
                'description' => Translate::get('Support that little extra to help the stream grow with some extras as a thanks.'),
                'features' => [
                    'All Tier 1 Benefits',
                    'Free Sub to gift to someone else',
                ],
                'alternates' => [
                    [
                        'name' => 'Tier 2 Subscriber - 3 Months',
                        'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_2_3_MONTH_PLAN_ID'),
                        'price' => 29.97,
                        'description' => Translate::get('Renew every 3 months'),
                    ],
                    [
                        'name' => 'Tier 2 Subscriber - 6 Months',
                        'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_2_6_MONTH_PLAN_ID'),
                        'price' => 59.94,
                        'description' => Translate::get('Renew every 6 months'),
                    ],
                ],
            ],
            [
                'name' => 'Tier 3 Subscriber',
                'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_3_1_MONTH_PLAN_ID'),
                'price' => 24.99,
                'description' => Translate::get('Go way above the call of duty and get some extra special exclusives in return.'),
                'features' => [
                    'All Tier 2 Benefits',
                    'Free Sub to gift to someone else',
                ],
                'alternates' => [
                    [
                        'name' => 'Tier 3 Subscriber - 3 Months',
                        'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_3_3_MONTH_PLAN_ID'),
                        'price' => 74.97,
                        'description' => Translate::get('Renew every 3 months'),
                    ],
                    [
                        'name' => 'Tier 3 Subscriber - 6 Months',
                        'stripe_id' => env('STRIPE_SUBSCRIBER_TIER_3_6_MONTH_PLAN_ID'),
                        'price' => 149.94,
                        'description' => Translate::get('Renew every 6 months'),
                    ],
                ],
            ],
        ],
    ],
];
