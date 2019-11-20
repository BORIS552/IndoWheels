<?php

namespace App\Policies;

use App\User;
use App\Prize;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrizePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the prize.
     *
     * @param  \App\User  $user
     * @param  \App\Prize  $prize
     * @return mixed
     */
    public function view(User $user, Prize $prize)
    {
        return true;
    }

    /**
     * Determine whether the user can create prizes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the prize.
     *
     * @param  \App\User  $user
     * @param  \App\Prize  $prize
     * @return mixed
     */
    public function update(User $user, Prize $prize)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the prize.
     *
     * @param  \App\User  $user
     * @param  \App\Prize  $prize
     * @return mixed
     */
    public function delete(User $user, Prize $prize)
    {
        return $user->is_admin;
    }
}
