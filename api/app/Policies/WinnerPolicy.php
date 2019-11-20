<?php

namespace App\Policies;

use App\User;
use App\Winner;
use Illuminate\Auth\Access\HandlesAuthorization;

class WinnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the winner.
     *
     * @param  \App\User  $user
     * @param  \App\Winner  $winner
     * @return mixed
     */
    public function view(User $user, Winner $winner)
    {
        return true;
    }

    /**
     * Determine whether the user can create winners.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the winner.
     *
     * @param  \App\User  $user
     * @param  \App\Winner  $winner
     * @return mixed
     */
    public function update(User $user, Winner $winner)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the winner.
     *
     * @param  \App\User  $user
     * @param  \App\Winner  $winner
     * @return mixed
     */
    public function delete(User $user, Winner $winner)
    {
        return $user->is_admin;
    }
}
