<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /**
     * The users that belong to this role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    /**
     * The permissions that belong to this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Assign a permission to this role without detaching existing ones.
     */
    public function assignPermission(Permission $permission)
    {
        return $this->permissions()->syncWithoutDetaching($permission);
    }

    /**
     * Remove a permission from this role.
     */
    public function removePermission(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }
}

