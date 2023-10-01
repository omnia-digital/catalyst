<?php

namespace Modules\Feeds\Enums;

enum FeedSourceType: string
{
    case RSS = 'rss';

    public static function options(): array
    {
        return [
            self::RSS->value => 'RSS',
        ];
    }

    public function label(): string
    {
        return self::options()[$this->value] ?? 'Unknown';
    }
}
