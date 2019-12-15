<?php

namespace App\Repositories\Traits;

use App\Criterion\Eloquent\OnlyTrashedCriteria;
use Prettus\Repository\Events\RepositoryEntityUpdated;

trait SoftDeletable
{
    /**
     * @param int $id
     *
     * @return mixed
     */
    public function restore($id)
    {
        return $this->manageDeletes($id, 'restore');
    }

    /**
     * @param string $id
     * @param string $method
     *
     * @return mixed
     */
    private function manageDeletes(string $id, string $method)
    {
        $this->applyScope();
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $this->pushCriteria(new OnlyTrashedCriteria);
        $model = $this->find($id);
        $originalModel = clone $model;
        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();
        $model->{$method}();
        event(new RepositoryEntityUpdated($this, $originalModel));

        return $this->parserResult($model);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function forceDelete(string $id)
    {
        return $this->manageDeletes($id, 'forceDelete');
    }
}
