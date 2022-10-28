<?php

namespace App\Enums\Teams;

enum TeamBillingPeriod: string
{
    case DAILY = 'day';
    case WEEKLY = 'week';
    case MONTHLY = 'month';
    case YEARLY = 'year';

    public static function options(): array
    {
        return [
            self::DAILY->value => 'Daily',
            self::WEEKLY->value => 'Weekly',
            self::MONTHLY->value => 'Monthly',
            self::YEARLY->value => 'Yearly',
        ];
    }
}
