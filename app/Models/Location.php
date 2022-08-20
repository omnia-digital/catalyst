<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Location extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function name(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $attributes['city'] . ', ' . $attributes['state'] . ', ' . $attributes['country']
        );
    }

    public function full(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                $address = '';
                $address .= $attributes['address'];

                if ($attributes['address_line_2']) {
                    $address .= " " . $attributes['address_line_2'];
                }

                $address .= ", " . $attributes['city'] . ', ' . $attributes['state'] . ', ' . $attributes['postal_code'] . " " . $attributes['country'];

                return $address;
            }
        );
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Builder<Model>
     */
    public function scopeSearch(Builder $query, ?string $search): \Illuminate\Database\Eloquent\Builder
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

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Builder<Model>
     */
    public function scopeHasCoordinates(Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where(function (Builder $query) {
            $query->where(function (Builder $query) {
                $query->whereNotNull('lat')->orWhere('lat', '!=', '');
            })->orWhere(function (Builder $query) {
                $query->whereNotNull('lng')->orWhere('lng', '!=', '');
            });
        });
    }

    public function model(): MorphTo
    {
        return $this->morphTo('model');
    }
}
