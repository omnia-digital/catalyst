<?php

namespace Modules\Payments\Enums;

enum PaymentGateway: string
{
    case Chargent = 'chargent';
    case Stripe = 'stripe';
}
