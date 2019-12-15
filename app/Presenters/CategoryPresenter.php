<?php

namespace App\Presenters;

use League\Fractal\TransformerAbstract;
use App\Transformers\CategoryTransformer;

/**
 * Class CategoryPresenter.
 */
class CategoryPresenter extends BasePresenter
{
    /**
     * Transformer.
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return new CategoryTransformer();
    }
}
