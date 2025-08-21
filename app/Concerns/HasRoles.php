<?php

namespace App\Concerns;

use App\Models\Role;

trait HasRoles
{
    /**
     * Check if the user has a specific ability.
     *
     * @param string $role
     * @return bool
     */
    public function hasAbility(string $ability): bool
    {

        $denied = $this->roles()
            ->whereHas('abilities', function ($query) use ($ability) {
                $query->where('ability', $ability)
                    ->where('type', 'deny');
            })
            ->exists();

        if ($denied) {
            return false;
        }


        return $this->roles()
            ->whereHas('abilities', function ($query) use ($ability) {
                $query->where('ability', $ability)
                    ->where('type', 'allow');
            })
            ->exists();
    }



    /**
     * Get all roles associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->morphToMany(Role::class, 'authorizable',  'role_user');
    }
}
