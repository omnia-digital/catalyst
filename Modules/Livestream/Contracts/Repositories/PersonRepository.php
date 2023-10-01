<?php

namespace People\App\Contracts\Repositories;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

interface PersonRepository
{
    /**
     * Get the current person of the application.
     *
     * @return Authenticatable|null
     */
    public function current();

    /**
     * Get the person with the given ID.
     *
     * @param int $id
     * @return Authenticatable|null
     */
    public function find($id);

    /**
     * Perform a basic person search by name or e-mail address.
     *
     * @param string $query
     * @param Authenticatable|null $excludePerson
     * @return Collection
     */
    public function search($query, $excludePerson = null);

    /**
     * Create a new person with the given data.
     *
     * @return Authenticatable
     */
    public function create(array $data);

    /**
     * Update the billing address information with the given data.
     *
     * @param Authenticatable $person
     * @return void
     */
    public function updateBillingAddress($person, array $data);

    /**
     * Update the European VAT ID number for the given person.
     *
     * @param Authenticatable $person
     * @param string $vatId
     * @return void
     */
    public function updateVatId($person, $vatId);
}
