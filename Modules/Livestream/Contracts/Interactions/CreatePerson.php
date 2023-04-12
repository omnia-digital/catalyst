<?php

namespace People\App\Contracts\Interactions;

interface CreatePerson
{
    /**
     * Get a validator instance for the request.
     *
     * @param  \Laravel\Spark\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Validation\Validator
     */
    public function validator($request);

    /**
     * Create a new user instance in the database.
     *
     * @param  \Laravel\Spark\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function handle($request);
}
