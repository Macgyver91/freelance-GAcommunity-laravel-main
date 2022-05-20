<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */

    public function update(User $user, User $model)
    {
        // If the logged in user is equal to the user passed then return true (= pass this request), if not deny the update process
        return $user->is($model);
    }

}
