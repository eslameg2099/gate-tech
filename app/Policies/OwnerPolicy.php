<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Owner;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laraeast\LaravelSettings\Facades\Settings;

class OwnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any owners.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.owners');
    }

    /**
     * Determine whether the user can view the owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Owner $owner
     * @return mixed
     */
    public function view(User $user, Owner $owner)
    {
        return $user->isAdmin()
            || $user->is($owner)
            || $user->hasPermissionTo('manage.owners');
    }

    /**
     * Determine whether the user can create owners.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.owners');
    }

    /**
     * Determine whether the user can update the owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Owner $owner
     * @return mixed
     */
    public function update(User $user, Owner $owner)
    {
        return (
                $user->isAdmin()
                || $user->is($owner)
                || $user->hasPermissionTo('manage.owners')
            )
            && ! $this->trashed($owner);
    }

    /**
     * Determine whether the user can update the type of the owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Owner $owner
     * @return mixed
     */
    public function updateType(User $user, Owner $owner)
    {
        return $user->isAdmin() && $user->isNot($owner) || $user->hasPermissionTo('manage.owners');
    }

    /**
     * Determine whether the user can delete the owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Owner $owner
     * @return mixed
     */
    public function delete(User $user, Owner $owner)
    {
        return (
                $user->isAdmin()
                && $user->isNot($owner)
                || $user->hasPermissionTo('manage.owners')
            )
            && ! $this->trashed($owner);
    }

    /**
     * Determine whether the user can view trashed owners.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.owners')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed owner.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Owner $owner
     * @return mixed
     */
    public function viewTrash(User $user, Owner $owner)
    {
        return $this->view($user, $owner) && $this->trashed($owner);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Owner $owner
     * @return mixed
     */
    public function restore(User $user, Owner $owner)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.owners')
            )
            && $this->trashed($owner);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Owner $owner
     * @return mixed
     */
    public function forceDelete(User $user, Owner $owner)
    {
        return (
                $user->isAdmin()
                && $user->isNot($owner)
                || $user->hasPermissionTo('manage.owners')
            )
            && $this->trashed($owner)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given owner is trashed.
     *
     * @param $owner
     * @return bool
     */
    public function trashed($owner)
    {
        return $this->hasSoftDeletes() && method_exists($owner, 'trashed') && $owner->trashed();
    }

    /**
     * Determine wither the model use soft deleting trait.
     *
     * @return bool
     */
    public function hasSoftDeletes()
    {
        return in_array(
            SoftDeletes::class,
            array_keys((new \ReflectionClass(Owner::class))->getTraits())
        );
    }
}
