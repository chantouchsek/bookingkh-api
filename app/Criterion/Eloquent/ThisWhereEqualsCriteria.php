<?php

namespace App\Criterion\Eloquent;

use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisWhereEqualsCriteria implements CriteriaInterface
{
    /**
     * @var string
     */
    protected $column;

    /**
     * @var string
     */
    protected $value;

    /**
     * ThisWhereEqualsCriteria constructor.
     * @param string $column
     * @param string $value
     */
    public function __construct(string $column, string $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

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
        return $model->where($this->column, $this->value);
    }
}
