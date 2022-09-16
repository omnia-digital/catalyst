<?php

namespace Modules\Subscriptions\Enums;

enum PaymentGateway: string
{
    case Chargent = 'chargent';
    case Stripe = 'stripe';
}
