<?php

namespace App\Contracts\Repositories;

use App\Contracts\RepositoryContract;

interface LivestreamRepositoryContract extends RepositoryContract
{
    /**
     * Get the LivestreamAccount with the given ID.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function find($id);

    /**
     * Perform a basic LivestreamAccount search by name or e-mail address.
     *
     * @param  string  $query
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $excludeLivestreamAccount
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($query, $excludeLivestreamAccount = null);

    /**
     * Create a new LivestreamAccount with the given data.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create($user,array $data);
}
