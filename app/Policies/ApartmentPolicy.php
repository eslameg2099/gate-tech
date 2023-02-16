<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Apartment;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any apartments.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.apartments');
    }

    /**
     * Determine whether the user can view the apartment.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Apartment $apartment
     * @return mixed
     */
    public function view(User $user, Apartment $apartment)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.apartments');
    }

    /**
     * Determine whether the user can create apartments.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.apartments');
    }

    /**
     * Determine whether the user can update the apartment.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Apartment $apartment
     * @return mixed
     */
    public function update(User $user, Apartment $apartment)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.apartments'))
            && ! $this->trashed($apartment);
    }

    /**
     * Determine whether the user can delete the apartment.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Apartment $apartment
     * @return mixed
     */
    public function delete(User $user, Apartment $apartment)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.apartments'))
            && ! $this->trashed($apartment);
    }

    /**
     * Determine whether the user can view trashed apartments.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.apartments'))
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed apartment.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Apartment $apartment
     * @return mixed
     */
    public function viewTrash(User $user, Apartment $apartment)
    {
        return $this->view($user, $apartment)
            && $apartment->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Apartment $apartment
     * @return mixed
     */
    public function restore(User $user, Apartment $apartment)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.apartments'))
            && $this->trashed($apartment);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Apartment $apartment
     * @return mixed
     */
    public function forceDelete(User $user, Apartment $apartment)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.apartments'))
            && $this->trashed($apartment)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given apartment is trashed.
     *
     * @param $apartment
     * @return bool
     */
    public function trashed($apartment)
    {
        return $this->hasSoftDeletes() && method_exists($apartment, 'trashed') && $apartment->trashed();
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
            array_keys((new \ReflectionClass(Apartment::class))->getTraits())
        );
    }
}
