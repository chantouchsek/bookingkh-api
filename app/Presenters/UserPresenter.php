<?php

namespace App\Presenters;

use App\Transformers\UserTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class UserPresenter.
 */
class UserPresenter extends BasePresenter
{
    /**
     * Transformer.
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserTransformer();
    }
}
