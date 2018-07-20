<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 20/07/2018
 * Time: 18:57
 */

namespace Vittel\Exception;

class FileNotFoundException extends \Exception
{
    public function __construct($file = "")
    {
        parent::__construct('File '.$file.' not found', 0, null);
    }


}