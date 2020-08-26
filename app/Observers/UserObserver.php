<?php

namespace PayBee\Observers;

use PayBee\Models\Token;
use PayBee\Models\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param User $user
     *
     * @return void
     * @throws \ErrorException
     */
    public function created(User $user)
    {
        $token = Token::forUser($user);
        $user->setRelation('token', $token);// we won't need to re-query for this further
    }

    /**
     * Handle the user "updated" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param User  $user
     *
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  User  $user
     *
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  User  $user
     *
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
