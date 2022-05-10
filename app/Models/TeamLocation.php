<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where(function (Builder $query) use ($search) {
            $query->where('address', 'LIKE', "%$search%")
                ->orWhere('address_line_2', 'LIKE', "%$search%")
                ->orWhere('city', 'LIKE', "%$search%")
                ->orWhere('state', 'LIKE', "%$search%")
                ->orWhere('postal_code', 'LIKE', "%$search%")
                ->orWhere('country', 'LIKE', "%$search%");
        });
    }
}
