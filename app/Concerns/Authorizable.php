<?php

namespace App\Concerns;

use Request;
use Illuminate\Support\Arr;

trait Authorizable
{
    /**
     * @var array
     */
    private $abilities = [
        'index' => 'viewAny',
        'show' => 'view',
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'destroy' => 'delete',
    ];

    /**
     * Override of callAction to perform the authorization before.
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if ($ability = $this->getAbility($method)) {
            $this->authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    /**
     * @param $method
     * @return string|null
     */
    public function getAbility($method)
    {
        $routeName = explode('.', Request::route()->getName());
        $action = Arr::get($this->getAbilities(), $method, []);

        return $action ? $action.'_'.$routeName[0] : null;
    }

    /**
     * @return array
     */
    private function getAbilities()
    {
        return $this->abilities;
    }

    /**
     * @param $abilities
     */
    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }
}
