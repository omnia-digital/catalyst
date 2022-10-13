<?php

namespace App\Support\Platform;

use App\Models\Team;
use App\Models\User;
use Modules\Social\Models\Mention;
use Modules\Social\Models\Post;

class TextProcessor 
{
    /**
     * Replace user mentions in body with links to the user profile
     * 
     * @param string $content
     * @return string
     */
    public static function replaceUserMentions($content)
    {
        return preg_replace_callback(
            Mention::USER_HANDLE_REGEX, 
            function ($matches) {
                if (is_null(User::findByHandle($matches[1]))) return $matches[0];

                return "<a x-data x-on:click.stop='' class='hover:underline hover:text-secondary' href='" . route('social.profile.show', $matches[1]) . "'>" . $matches[0] . "</a>";
            },
            $content
        );
    }

    /**
     * Replace team mentions in body with links to the user profile
     * 
     * @param string $content
     * @return string
     */
    public static function replaceTeamMentions($content)
    {
        return preg_replace_callback(
            Mention::TEAM_HANDLE_REGEX, 
            function ($matches) {
                if (is_null(Team::findByHandle($matches[1]))) {
                    return $matches[0];
                }

                return "<a x-data x-on:click.stop='' class='hover:underline hover:text-secondary' href='" . route('social.teams.show', $matches[1]) . "'>" . $matches[0] . "</a>";
            },
            $content
        );
    }

    public static function processMentionContent($content)
    {

        $content = Post::replaceUserMentions($content);

        $content = Post::replaceTeamMentions($content);

        return $content;
    }

    public static function getAllMentions($content)
    {
        return [
            self::getUserMentions($content), 
            self::getTeamMentions($content)
        ];
    }

    public static function getUserMentions($content)
    {
        $userMentions = array();

        preg_match_all(Mention::USER_HANDLE_REGEX, $content, $userMentions);

        return $userMentions[1];
    }

    public static function getTeamMentions($content)
    {
        $teamMentions = array();

        preg_match_all(Mention::TEAM_HANDLE_REGEX, $content, $teamMentions);

        return $teamMentions[1];
    }
}