<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\NullResource;

/**
 * Class UserTransformer.
 */
class UserTransformer extends BaseTransformer
{
    protected $availableIncludes = ['roles'];

    /**
     * Transform the User entity.
     *
     * @param User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        $response = [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
        ];

        return $this->addTimesHumanReadable($model, $response);
    }

    /**
     * @param User $user
     * @return Collection|NullResource
     */
    public function includeRoles(User $user)
    {
        if (empty($user->roles)) {
            return $this->null();
        }

        return $this->collection($user->roles, new RoleTransformer());
    }
}
