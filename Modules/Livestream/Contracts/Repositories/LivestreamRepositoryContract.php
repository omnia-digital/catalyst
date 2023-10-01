<?php

namespace Modules\Livestream\Contracts\Repositories;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Modules\Livestream\Contracts\RepositoryContract;

interface LivestreamRepositoryContract extends RepositoryContract
{
    /**
     * Get the LivestreamAccount with the given ID.
     *
     * @param  int  $id
     * @return Authenticatable|null
     */
    public function find($id);

    /**
     * Perform a basic LivestreamAccount search by name or e-mail address.
     *
     * @param  string  $query
     * @param  Authenticatable|null  $excludeLivestreamAccount
     * @return Collection
     */
    public function search($query, $excludeLivestreamAccount = null);

    /**
     * Create a new LivestreamAccount with the given data.
     *
     * @return Authenticatable
     */
    public function create($user, array $data);
}
