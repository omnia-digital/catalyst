<?php

namespace Modules\Forms\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Thomasjohnkane\Snooze\Models\ScheduledNotification;

class FormNotification extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['send_date_edit'];

    // protected static function newFactory()
    // {
    //     return \Modules\Forms\Database\factories\FormNotificationFactory::new();
    // }

    public function getPrintSendDateAttribute()
    {
        return Carbon::parse($this->send_date)->format('m/d/y');
    }

    public function getSendDateEditAttribute()
    {
        return Carbon::parse($this->send_date);
    }

    public function setSendDateEditAttribute($value)
    {
        $this->send_date = Carbon::parse($value);
    }

    // Relationships

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scheduledNotification()
    {
        return $this->belongsTo(ScheduledNotification::class);
    }
}
