<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 24/07/2018
 * Time: 18:05
 */

namespace Vittel\Http\Collection;


use Vittel\AbstractCollection;
use Vittel\Http\Entity\Route;

class RouteCollection extends AbstractCollection
{
    /**
     * @param Route $entity
     * @return $this
     */
    public function add($entity)
    {
        if (!is_a($entity, Route::class)) {
            throw new \InvalidArgumentException("L'entité n'est pas une route. ");
        }

        $this->collection[$entity->getPath()] = $entity;

        return $this;
    }

}