<?php

namespace People\App\Contracts\Repositories;

interface PersonRepository
{
    /**
     * Get the current person of the application.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function current();

    /**
     * Get the person with the given ID.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function find($id);

    /**
     * Perform a basic person search by name or e-mail address.
     *
     * @param  string  $query
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $excludePerson
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($query, $excludePerson = null);

    /**
     * Create a new person with the given data.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $data);

    /**
     * Update the billing address information with the given data.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $person
     * @param  array  $data
     * @return void
     */
    public function updateBillingAddress($person, array $data);

    /**
     * Update the European VAT ID number for the given person.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $person
     * @param  string  $vatId
     * @return void
     */
    public function updateVatId($person, $vatId);
}
