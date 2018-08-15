<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 15/08/2018
 * Time: 16:06
 */

namespace Vittel\Http\Repository;


use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Finder\Finder;
use Vittel\Http\Annotations\Route;
use Vittel\Http\Collection\RouteCollection;

class RouteAnnotationRepository implements RouteRepositoryInterface
{
    /**
     * @var AnnotationReader
     */
    protected $reader;
    protected $namespaces;

    function __construct(AnnotationReader $reader, array $namespaces)
    {
        $this->reader = $reader;
        $this->namespaces = $namespaces;
    }

    function findAll()
    {
        $response = new RouteCollection();

        foreach ($this->namespaces as $namespace=>$path) {
            $finder = new Finder();
            $finder->files()->in($path)->name('*.php');

            foreach ($finder as $result)
            {
                $className = str_replace(["/", ".php"], ["\\",""], $result->getRelativePathname());
                $className = "$namespace\\$className";
                /** @var Route $prefix */
                $prefix = $this->getReader()->getClassAnnotation(
                    new \ReflectionClass($className),
                    Route::class
                );
                if (count(get_class_methods($className))) {
                    foreach (get_class_methods($className) as $method)
                    {
                        /** @var Route $annotation */
                        $annotation = $this->getReader()->getMethodAnnotation(
                            new \ReflectionMethod($className,$method),
                            Route::class
                        );
                        if (!$annotation) {
                            continue;
                        }
                        $route = new \Vittel\Http\Entity\Route(
                            $prefix ? $prefix->getPath() . $annotation->getPath() : $annotation->getPath()
                        );
                        $route->setName($annotation->getName())->setController($className)->setMethod($method);
                        $response->add($route);
                    }
                }
            }
        }

        return $response;
    }

    public function findByPath($path)
    {
        return $this->findAll()[$path];
    }

    /**
     * @return AnnotationReader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param AnnotationReader $reader
     * @return RouteAnnotationRepository
     */
    public function setReader($reader)
    {
        $this->reader = $reader;
        return $this;
    }
}