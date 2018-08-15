<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 24/07/2018
 * Time: 18:32
 */

namespace Vittel\Http\Repository;


use Vittel\Helper\Config;
use Vittel\Http\Collection\RouteCollection;
use Vittel\Http\Entity\Route;

class RouteFileRepository implements RouteRepositoryInterface
{
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function findAll()
    {
        $data = Config::get($this->fileName);
        $collection = new RouteCollection();

        foreach ($data as $path => $values)
        {
            $collection->add(
                $this->generateRouteWithData($path, $values)
            );
        }

        return $collection;
    }

    public function findByPath($path)
    {
        $data = Config::get($this->fileName);
        return $this->generateRouteWithData($path, $data[$path]);
    }

    protected function generateRouteWithData($path, $values)
    {
        $route = new Route($path);
        $route
            ->setController($values['controller'])
            ->setMethod($values['method']);
        if (isset($values['name'])) {
            $route->setName($values['name']);
        }
        return $route;
    }
}