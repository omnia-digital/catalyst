<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use Modules\Livestream\Plans\HasPlan;
use Spark\Billable;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class Team extends JetstreamTeam
{
    use HasFactory;
    use Billable;
    use HasPlan;

    const DEFAULT_TEAM_NAME = 'Default Org';

    protected $with = [
        'owner',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
        'trial_ends_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'personal_team',
        'timezone',
        'default_bible',
        'photo_url',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function stripeEmail(): string
    {
        return $this->owner->email;
    }

    public function livestreamAccount(): HasOne
    {
        return $this->hasOne(LivestreamAccount::class);
    }

    public function extraInvoiceItems(): HasMany
    {
        return $this->hasMany(ExtraInvoiceItem::class);
    }

    // People associated with this team
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'team_person');
    }

    public function getLogoAttribute()
    {
        if (! $this->photo_url) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
        }

        if (Str::startsWith($this->photo_url, ['http', 'https'])) {
            return $this->photo_url;
        }

        return Storage::disk($this->logoDisk())->url($this->photo_url);
    }

    public function hasDefaultTeamName(): bool
    {
        return $this->name === self::DEFAULT_TEAM_NAME;
    }

    public function hasInfoIsFilled(): bool
    {
        return ! $this->hasDefaultTeamName() && ! empty($this->phone) && ! empty($this->city) && ! empty($this->state);
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteLogo()
    {
        Storage::disk($this->logoDisk())->delete($this->photo_url);

        $this->forceFill([
            'photo_url' => null,
        ])->save();
    }

    /**
     * Update the team logo.
     *
     * @return void
     */
    public function updateLogo(UploadedFile $photo)
    {
        tap($this->photo_url, function ($previous) use ($photo) {
            $this->forceFill([
                'photo_url' => $photo->storePublicly(
                    'logos', ['disk' => $this->logoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->logoDisk())->delete($previous);
            }
        });
    }

    public function hasUnpaidExtraInvoiceItems(): bool
    {
        return $this->extraInvoiceItems()->unpaid()->exists();
    }

    /**
     * Purge all of the team's resources.
     *
     * @return void
     */
    public function purge()
    {
        // Remove all users from this team
        $this->owner()->where('current_team_id', $this->id)
            ->update(['current_team_id' => null]);

        $this->users()->where('current_team_id', $this->id)
            ->update(['current_team_id' => null]);

        $this->users()->detach();

        // Disable and delete streams.
        $this->livestreamAccount->streams->each(fn (Stream $stream) => $stream->delete());

        // Delete episode templates.
        $this->livestreamAccount->episodeTemplates()->delete();

        // Delete stream targets.
        $this->livestreamAccount->streamTargets()->delete();

        // Delete players.
        $this->livestreamAccount->players()->delete();

        // Delete channels.
        $this->livestreamAccount->channels()->delete();

        // Delete livestream account.
        $this->livestreamAccount->delete();

        $this->delete();
    }

    /**
     * Get the disk that logo should be stored on.
     *
     * @return string
     */
    protected function logoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }
}
