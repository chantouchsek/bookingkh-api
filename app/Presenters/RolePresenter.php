<?php

namespace App\Presenters;

use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class RolePresenter.
 */
class RolePresenter extends BasePresenter
{
    /**
     * Transformer.
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoleTransformer();
    }
}
