<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Building;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuildingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any buildings.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.buildings');
    }

    /**
     * Determine whether the user can view the building.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Building $building
     * @return mixed
     */
    public function view(User $user, Building $building)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.buildings');
    }

    /**
     * Determine whether the user can create buildings.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.buildings');
    }

    /**
     * Determine whether the user can update the building.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     * @return mixed
     */
    public function update(User $user, Building $building)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.buildings'))
            && ! $this->trashed($building);
    }

    /**
     * Determine whether the user can delete the building.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     * @return mixed
     */
    public function delete(User $user, Building $building)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.buildings'))
            && ! $this->trashed($building);
    }

    /**
     * Determine whether the user can view trashed buildings.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.buildings'))
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed building.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Building $building
     * @return mixed
     */
    public function viewTrash(User $user, Building $building)
    {
        return $this->view($user, $building)
            && $building->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     * @return mixed
     */
    public function restore(User $user, Building $building)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.buildings'))
            && $this->trashed($building);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Building $building
     * @return mixed
     */
    public function forceDelete(User $user, Building $building)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.buildings'))
            && $this->trashed($building)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given building is trashed.
     *
     * @param $building
     * @return bool
     */
    public function trashed($building)
    {
        return $this->hasSoftDeletes() && method_exists($building, 'trashed') && $building->trashed();
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
            array_keys((new \ReflectionClass(Building::class))->getTraits())
        );
    }
}
