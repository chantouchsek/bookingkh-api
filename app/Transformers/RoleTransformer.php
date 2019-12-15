<?php

namespace App\Transformers;

use App\Models\Role;

/**
 * Class RoleTransformer.
 */
class RoleTransformer extends BaseTransformer
{
    /**
     * Transform the Role entity.
     *
     * @param Role $model
     *
     * @return array
     */
    public function transform(Role $model)
    {
        return [
            'id' => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
