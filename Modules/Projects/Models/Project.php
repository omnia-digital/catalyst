<?php

namespace Modules\Projects\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ["title","description","image", 'owner_id'];

    protected static function newFactory()
    {
        return \Modules\Projects\Database\factories\ProjectFactory::new();
    }

    public function getThumbnailAttribute($value)
    {
        if (empty($value)) {
            return 'https://via.placeholder.com/200';
        }
    }

    public function owner()
    {
        return $this->hasOne(User::class,'owner_id');
    }
}
