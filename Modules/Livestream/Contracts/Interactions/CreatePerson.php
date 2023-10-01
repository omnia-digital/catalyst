<?php

namespace People\App\Contracts\Interactions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\Validator;
use Laravel\Spark\Http\Requests\Auth\RegisterRequest;

interface CreatePerson
{
    /**
     * Get a validator instance for the request.
     *
     * @param  RegisterRequest  $request
     * @return Validator
     */
    public function validator($request);

    /**
     * Create a new user instance in the database.
     *
     * @param  RegisterRequest  $request
     * @return Authenticatable
     */
    public function handle($request);
}
