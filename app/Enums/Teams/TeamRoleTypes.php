<?php

namespace App\Enums\Teams;

enum TeamRoleTypes: string
{
    case OWNER = 'owner';
    case ADMIN = 'administration';
    case MEMBER = 'member';

    public static function keys(): array
    {
        return [
            self::OWNER->value,
            self::ADMIN->value,
            self::MEMBER->value,
        ];
    }

    public static function options(): array
    {
        return [
            self::OWNER->value => ucfirst(self::OWNER->value),
            self::ADMIN->value => ucfirst(self::ADMIN->value),
            self::MEMBER->value => ucfirst(self::MEMBER->value),
        ];
    }
}