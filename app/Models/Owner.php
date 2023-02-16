<?php

namespace App\Models;

use App\Models\Concerns\HasWallet;
use Parental\HasParent;
use App\Http\Filters\OwnerFilter;
use App\Http\Resources\OwnerResource;
use App\Models\Relations\OwnerRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends User
{
    use HasFactory;
    use HasParent;
    use OwnerRelations;
    use SoftDeletes;
    use HasWallet;

    /**
     * The model filter name.
     *
     * @var string
     */
    protected $filter = OwnerFilter::class;

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    {
        return User::class;
    }

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_id';
    }

    /**
     * @return \App\Http\Resources\OwnerResource
     */
    public function getResource()
    {
        return new OwnerResource($this);
    }

    /**
     * Get the dashboard profile link.
     *
     * @return string
     */
    public function dashboardProfile(): string
    {
        return route('dashboard.owners.show', $this);
    }
}
