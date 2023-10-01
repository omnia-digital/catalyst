<?php

namespace Modules\Livestream\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

interface RepositoryContract
{
    /**
     * Get the resource with the given ID.
     *
     * @param  int  $id
     * @return Authenticatable|null
     */
    public function find($id);

    /**
     * Perform a basic resource search by name or e-mail address.
     *
     * @param  string  $query
     * @param  Authenticatable|null  $excludeResource
     * @return Collection
     */
    public function search($query, $excludeResource = null);

    /**
     * Create a new resource with the given data.
     *
     * @return Authenticatable
     */
    public function create($user, array $data);
}
