<?php

namespace Modules\Social\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Social\Notifications\SomeoneMentionedYouNotification;

class Mention extends Model
{
    use HasFactory;

    public const USER_HANDLE_REGEX = '/(?<![\S])@([a-z0-9_-]+)/';

    public const TEAM_HANDLE_REGEX = '/(?<![\S])@{2}([a-z0-9_-]+)/';

    protected $guarded = [];

    public static function createManyFromHandles($handles, $type, $post)
    {
        foreach ($handles as $handle) {
            if (is_null($type::findByHandle($handle))) {
                continue;
            }

            $mentionAlreadyExists = Mention::where([
                'mentionable_type' => $type,
                'mentionable_id' => $type::findByHandle($handle)->id,
                'postable_id' => $post->id,
            ])->exists();

            ! $mentionAlreadyExists &&
                Mention::create([
                    'mentionable_type' => $type,
                    'mentionable_id' => $type::findByHandle($handle)->id,
                    'postable_type' => $post::class,
                    'postable_id' => $post->id,
                ]);
        }
    }

    /**
     * Replace user mentions in body with links to the user profile
     *
     * @param  string  $content
     * @return string
     */
    public static function replaceUserMentions($content)
    {
        return preg_replace_callback(
            Mention::USER_HANDLE_REGEX,
            function ($matches) {
                if (is_null(User::findByHandle($matches[1]))) {
                    return $matches[0];
                }

                return "<a x-data x-on:click.stop='' class='hover:underline hover:text-secondary' href='" . route('social.profile.show', $matches[1]) . "'>" . $matches[0] . '</a>';
            },
            $content
        );
    }

    /**
     * Replace team mentions in body with links to the user profile
     *
     * @param  string  $content
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

                return "<a x-data x-on:click.stop='' class='hover:underline hover:text-secondary' href='" . route('social.teams.show', $matches[1]) . "'>" . $matches[0] . '</a>';
            },
            $content
        );
    }

    public static function processMentionContent($content)
    {
        $content = self::replaceUserMentions($content);

        $content = self::replaceTeamMentions($content);

        return $content;
    }

    public static function getAllMentions($content)
    {
        return [
            self::getUserMentions($content),
            self::getTeamMentions($content),
        ];
    }

    public static function getUserMentions($content)
    {
        $userMentions = [];

        preg_match_all(Mention::USER_HANDLE_REGEX, $content, $userMentions);

        return $userMentions[1];
    }

    public static function getTeamMentions($content)
    {
        $teamMentions = [];

        preg_match_all(Mention::TEAM_HANDLE_REGEX, $content, $teamMentions);

        return $teamMentions[1];
    }

    protected static function newFactory()
    {
        return \Modules\Social\Database\Factories\MentionFactory::new();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($mention) {
            $mention->mentionable->notify(new SomeoneMentionedYouNotification($mention));
        });
    }

    public function mentionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function postable(): MorphTo
    {
        return $this->morphTo();
    }

    public function poster()
    {
        return $this->hasOneThrough(User::class, Post::class);
    }
}
