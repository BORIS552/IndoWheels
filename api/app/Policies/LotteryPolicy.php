<?php

namespace App\Policies;

use App\User;
use App\Lottery;
use Illuminate\Auth\Access\HandlesAuthorization;

class LotteryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the lottery.
     *
     * @param  \App\User  $user
     * @param  \App\Lottery  $lottery
     * @return mixed
     */
    public function view(User $user, Lottery $lottery)
    {
        return true;
    }

    /**
     * Determine whether the user can create lotteries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the lottery.
     *
     * @param  \App\User  $user
     * @param  \App\Lottery  $lottery
     * @return mixed
     */
    public function update(User $user, Lottery $lottery)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the lottery.
     *
     * @param  \App\User  $user
     * @param  \App\Lottery  $lottery
     * @return mixed
     */
    public function delete(User $user, Lottery $lottery)
    {
        return $user->is_admin;
    }
}
