<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Str;

class ModelPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }



    public function __call($name, $arguments)
    {
        if ($name === 'viewAny') {
            $name = 'view';
        }

        /** @var \App\Models\User $user */
        $user = $arguments[0];

        $modelName = Str::snake(
            Str::pluralStudly(
                Str::before(class_basename($this), 'Policy')
            )
        );

        $ability = $modelName . '.' . Str::snake($name);

        // If a model instance is passed, enforce store ownership
        if (isset($arguments[1])) {
            $model = $arguments[1];

            // Make sure we have store_id loaded
            if (is_object($model) && method_exists($model, 'getKey') && $model->store_id === null) {
                $model = $model->fresh(['store']); // reload with relation if needed
            }

            // Skip check for super admin
            if (! $user->super_admin) {
                if ($user->store_id !== null) {
                    // If still no store_id on model, treat as unauthorized
                    if (! isset($model->store_id) || $model->store_id != $user->store_id) {
                        return false;
                    }
                }
            }
        }

        return $user->hasAbility($ability);
    }




    // public function __call($name, $arguments)
    // {

    //     if ($name == 'viewAny') {
    //         $name = 'view';
    //     }

    //     /** @var User $user */
    //     $user = $arguments[0];

    //     // Determine model name from policy class name
    //     $modelName = Str::snake(
    //         Str::pluralStudly(
    //             Str::before(class_basename($this), 'Policy')
    //         )
    //     );

    //     // Build ability name
    //     $ability = $modelName . '.' . Str::snake($name);

    //     if (isset($arguments[1])) {
    //         $model = $arguments[1];

    //         // Super admin or no store restriction
    //         if (! $user->super_admin && $user->store_id !== null) {
    //             if ($model->store_id !== $user->store_id) {
    //                 return false;
    //             }
    //         }
    //     }


    //     return $user->hasAbility($ability);
    // }















    // public function __call($name, $arguments)
    // {



    //     if ($name == 'viewAny') {
    //         $name = 'view';
    //     }
    //     /** @var User $user */
    //     $user = $arguments[0];

    //     // Determine model name from policy class name
    //     // Example: ProductPolicy -> "products"
    //     $modelName = Str::snake(
    //         Str::pluralStudly(
    //             Str::before(class_basename($this), 'Policy')
    //         )
    //     );

    //     // Build ability name
    //     // Example: "products.view", "products.update"
    //     $ability = $modelName . '.' . Str::snake($name);

    //     if (isset($arguments[1])) {
    //         $model = $arguments[1];
    //         if ($model->store_id !== $user->store_id) {
    //             return false;
    //         }
    //     }

    //     // Allow if the user has the ability
    //     return $user->hasAbility($ability);
    // }
}
