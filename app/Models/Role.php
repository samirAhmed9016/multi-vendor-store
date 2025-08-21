<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    /**
     * Create a new role with abilities.
     *
     * @param string $name
     * @param array $abilities
     * @return static
     */

    public static function createWithAbilities(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $role = Role::create([
                'name' => $request->post('name'),
            ]);

            foreach ($request->post('abilities') as $ability => $value) {
                RoleAbility::create([
                    'role_id' => $role->id,
                    'ability' => $ability,
                    'type' => $value,
                ]);
            }

            return $role;
        });
    }

    public function updateWithAbilities(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $this->update([
                'name' => $request->post('name'),
            ]);

            foreach ($request->post('abilities') as $ability => $value) {
                RoleAbility::updateOrCreate(
                    [
                        'role_id' => $this->id,
                        'ability' => $ability,
                    ],
                    [
                        'type' => $value,
                    ]
                );
            }

            return $this;
        });
    }


    public function abilities()
    {
        return $this->hasMany(RoleAbility::class);
    }
}
