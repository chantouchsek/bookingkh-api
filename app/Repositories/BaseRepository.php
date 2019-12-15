<?php

namespace App\Repositories;

use Prettus\Repository\Traits\CacheableRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository as BaseRepo;

abstract class BaseRepository extends BaseRepo implements CacheableInterface
{
    use CacheableRepository {
        serializeCriteria as protected serializeCriteriaOverride;
    }

    /**
     * {@inheritdoc}
     */
    protected function serializeCriteria()
    {
        /*
         * this will remove if pull request merge.
         * https://github.com/andersao/l5-repository/pull/581
         */
        return $this->serializeCriteriaOverride().serialize($this->presenter);
    }
}
