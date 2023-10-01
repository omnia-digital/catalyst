<?php

namespace Modules\Feeds\Enums;

enum FeedSourceType: string
{
    case RSS = 'rss';

    public function label(): string
    {
        return self::options()[$this->value] ?? 'Unknown';
    }

    public static function options(): array
    {
        return [
            self::RSS->value => 'RSS',
        ];
    }
}
