<?php

namespace Modules\Forms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class FormTypePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        return false;
    }

    public function viewAny()
    {
        return auth()->user()->is_admin;
    }

    public function view()
    {
        return false;
        return auth()->user()->can('view forms');
    }
}
