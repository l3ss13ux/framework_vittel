<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 24/07/2018
 * Time: 19:27
 */

namespace Vittel\Http\Annotations;

/**
 * Class Route
 * @package Vittel\Http\Annotations
 * @Annotation
 */
class Route
{
    public $name;
    public $path;

    public function __construct(array $data)
    {
        $this->path = isset($data['path']) ? $data['path'] : $data['value'];
        $this->name = isset($data['name']) ? $data['name'] : null;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

}