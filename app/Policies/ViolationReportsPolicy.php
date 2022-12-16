<?php

namespace App\Policies;

use App\Models\User;
use App\Models\violationReports;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViolationReportsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\violationReports  $violationReports
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, violationReports $violationReports)
    {
        return $user->id === $violationReports->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->id === $violationReports->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\violationReports  $violationReports
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, violationReports $violationReports)
    {
        return $user->id === $violationReports->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\violationReports  $violationReports
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, violationReports $violationReports)
    {

        switch ($violationReports->role->name) {
            case 'admin':
                return $user->id === $violationReports->from_user_id;
            break;
            case 'user':
                return $user->id === $violationReports->to_user_id;
            break;
            case 'client':
                return $user->id === $violationReports->to_user_id;
            break;
            default:
               dd('check policy violationreports');
                break;
        }

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\violationReports  $violationReports
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, violationReports $violationReports)
    {
        return $user->id === $violationReports->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\violationReports  $violationReports
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, violationReports $violationReports)
    {
        //
    }
}
