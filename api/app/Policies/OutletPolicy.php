<?php

namespace App\Policies;

use App\User;
use App\Outlet;
use Illuminate\Auth\Access\HandlesAuthorization;

class OutletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the outlet.
     *
     * @param  \App\User  $user
     * @param  \App\Outlet  $outlet
     * @return mixed
     */
    public function view(User $user, Outlet $outlet)
    {
        return true;
    }

    /**
     * Determine whether the user can create outlets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the outlet.
     *
     * @param  \App\User  $user
     * @param  \App\Outlet  $outlet
     * @return mixed
     */
    public function update(User $user, Outlet $outlet)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the outlet.
     *
     * @param  \App\User  $user
     * @param  \App\Outlet  $outlet
     * @return mixed
     */
    public function delete(User $user, Outlet $outlet)
    {
        return $user->is_admin;
    }
}
