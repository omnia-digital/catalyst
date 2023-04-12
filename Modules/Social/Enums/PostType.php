<?php

namespace Modules\Social\Enums;

enum PostType: string
{
    case ARTICLE = 'article';
    case RESOURCE = 'resource';
    case QUESTION = 'question';
    case FEED = 'feed';
}
