<?php

namespace Modules\Billing\Enums;

enum PaymentGateway: string
{
    case Chargent = 'chargent';
    case Stripe = 'stripe';
}
