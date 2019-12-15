<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

/**
 * Class CategoryTransformer.
 */
class CategoryTransformer extends BaseTransformer
{
    protected $availableIncludes = [];

    /**
     * Transform the Category entity.
     *
     * @param Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        $response = [
            'id' => $model->getRouteKey(),
            'title' => $model->title,
            'description' => $model->description,
            'user_id' => $model->user_id,
        ];
        $response = $this->filterData($response, [
            'real_id' => $model->id,
        ]);

        return $this->addTimesHumanReadable($model, $response);
    }

    /**
     * @param Category $category
     * @return Item|NullResource
     */
    public function includeUser(Category $category)
    {
        if (empty($category->user)) {
            return $this->null();
        }

        return $this->item($category->user, new UserTransformer());
    }
}
