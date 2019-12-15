<?php

namespace App\Criterion\Eloquent;

use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisOrWhereEqualsCriteria implements CriteriaInterface
{
    /**
     * @var array
     */
    private $where;

    /**
     * ThisOrWhereEqualsCriteria constructor.
     * @param array $where
     */
    public function __construct(array $where)
    {
        $this->where = $where;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param Builder $model
     * @param RepositoryInterface $repository
     *
     * @return Builder $model
     */
    public function apply($model, RepositoryInterface $repository)
    {
        foreach ($this->where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $model = $model->orWhere($field, $condition, $val);
            } else {
                $model = $model->orWhere($field, '=', $value);
            }
        }

        return $model;
    }
}
