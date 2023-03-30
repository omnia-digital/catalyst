<?php

namespace Modules\Livestream\Contracts;

    interface RepositoryContract
    {
        /**
         * Get the resource with the given ID.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\Auth\Authenticatable|null
         */
        public function find($id);

        /**
         * Perform a basic resource search by name or e-mail address.
         *
         * @param  string  $query
         * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $excludeResource
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function search($query, $excludeResource = null);

        /**
         * Create a new resource with the given data.
         *
         * @return \Illuminate\Contracts\Auth\Authenticatable
         */
        public function create($user, array $data);
    }
