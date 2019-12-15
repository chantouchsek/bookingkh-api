<?php

namespace App\Presenters;

use Exception;
use League\Fractal\Resource\ResourceAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

abstract class BasePresenter extends FractalPresenter
{
    /**
     * BasePresenter constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->resourceKeyCollection = 'data';
        $this->resourceKeyItem = 'data';
    }

    /**
     * {@inheritdoc}
     */
    protected function transformItem($data)
    {
        return $this->addAvailableIncludeToMeta(parent::transformItem($data));
    }

    /**
     * @param ResourceAbstract $resource
     *
     * @return ResourceAbstract
     */
    private function addAvailableIncludeToMeta(ResourceAbstract $resource)
    {
        $resource->setMeta([
            'include' => $this->getTransformer()->getAvailableIncludes(),
        ]);

        return $resource;
    }

    /**
     * {@inheritdoc}
     */
    protected function transformCollection($data)
    {
        return $this->addAvailableIncludeToMeta(parent::transformCollection($data));
    }

    /**
     * {@inheritdoc}
     */
    protected function transformPaginator($paginator)
    {
        return $this->addAvailableIncludeToMeta(parent::transformPaginator($paginator));
    }
}
