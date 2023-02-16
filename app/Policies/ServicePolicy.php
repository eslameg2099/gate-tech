<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any services.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.services');
    }

    /**
     * Determine whether the user can view the service.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function view(User $user, Service $service)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.services');
    }

    /**
     * Determine whether the user can create services.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.services');
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.services'))
            && ! $this->trashed($service);
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.services'))
            && ! $this->trashed($service);
    }

    /**
     * Determine whether the user can view trashed services.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.services'))
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed service.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function viewTrash(User $user, Service $service)
    {
        return $this->view($user, $service)
            && $service->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function restore(User $user, Service $service)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.services'))
            && $this->trashed($service);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function forceDelete(User $user, Service $service)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.services'))
            && $this->trashed($service)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given service is trashed.
     *
     * @param $service
     * @return bool
     */
    public function trashed($service)
    {
        return $this->hasSoftDeletes() && method_exists($service, 'trashed') && $service->trashed();
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
            array_keys((new \ReflectionClass(Service::class))->getTraits())
        );
    }
}
