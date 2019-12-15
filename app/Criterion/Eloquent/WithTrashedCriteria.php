<?php

namespace App\Criterion\Eloquent;

use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class WithTrashedCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository.
     *
     * @param Builder $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->withTrashed();
    }
}
