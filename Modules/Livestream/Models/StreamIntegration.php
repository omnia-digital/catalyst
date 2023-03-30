<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Model;

class StreamIntegration extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'livestream_stream_integrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enabled',
        'provider',
        'access_token',
        'provider_team_object',
        'episode_template_id',
        'livestream_account_id',
    ];

    /**
     * @return bool
     */
    public function getEnabledAttribute($value)
    {
        return $this->attributes['enabled'] = $value === 1;
    }

    public function setEnabledAttribute($value)
    {
        $this->attributes['enabled'] = (int) $value;
    }

    /**
     * @return string
     */
    public function setProviderTeamObjectAttribute($value)
    {
        $this->attributes['provider_team_object'] = json_encode($value);
    }

    /**
     * @return mixed
     */
    public function getProviderTeamObjectAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function LivestreamAccount()
    {
        return $this->belongsTo(LivestreamAccount::class);
    }

    /**
     * Stream Integrations are assigned to One Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function team()
    {
        return $this->hasManyThrough(Team::class, LivestreamAccount::class);
    }

    /**
     * Stream Integrations can have one Episode Template
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function episodeTemplate()
    {
        return $this->belongsTo(EpisodeTemplate::class);
    }
}
