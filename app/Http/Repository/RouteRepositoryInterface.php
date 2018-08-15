<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 15/08/2018
 * Time: 16:35
 */

namespace Vittel\Http\Repository;


interface RouteRepositoryInterface
{

    public function findAll();

    public function findByPath($path);

}