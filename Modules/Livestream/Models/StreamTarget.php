<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StreamTarget extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'livestream_stream_targets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'enabled',
        'url',
        'stream_key',
        'passthrough',
        'status',
        'stream_id',
        'stream_integration_id',
        'mux_simulcast_target_id'
    ];

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }
}
