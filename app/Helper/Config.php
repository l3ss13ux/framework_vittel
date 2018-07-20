<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 18/07/2018
 * Time: 19:40
 */

namespace Vittel\Helper;


use Symfony\Component\Yaml\Yaml;
use Vittel\Exception\FileNotFoundException;

/**
 * Class Config
 * @package Vittel\Helper
 */
class Config
{
    /**
     * @var string
     */
    private static $dir;

    /**
     * Initialise la classe
     *
     * @param string $dirName
     */
    public static function init($dirName)
    {
        self::$dir = $dirName;
    }

    /**
     * Récupére une configuration
     *
     * @param $file
     * @return array|mixed
     * @throws FileNotFoundException
     */
    public static function get($file)
    {
        if (!self::fileExist($file)) {
            throw new FileNotFoundException(self::getFileName($file));
        }
        return self::parseFile($file);
    }

    /**
     * Récupère le nom du dossier de configuration
     *
     * @return string
     */
    public static function getDir()
    {
        return self::$dir;
    }

    /**
     * Récupère le nom complet du fichier
     *
     * @param string $file
     * @return string
     */
    private static function getFileName($file)
    {
        return self::getDir().'/'.$file;
    }

    /**
     * Vérifie si un fichier existe
     *
     * @param string $file
     * @return bool
     */
    private static function fileExist($file)
    {
        return is_file(self::getFileName($file));
    }

    /**
     * Récupère l'extension d'un fichier
     *
     * @param string $file
     * @return string
     */
    private static function getExtension($file)
    {
        if (!self::fileExist($file)) {
            return "";
        }
        return pathinfo(self::getFileName($file))['extension'];
    }

    /**
     * Récupère le contenu d'un fichier
     *
     * @param string $file
     * @return bool|string
     */
    private static function getFileContent($file)
    {
        if (!self::fileExist($file)) {
            return "";
        }
        return file_get_contents(self::getFileName($file));
    }

    /**
     * Parse un fichier
     *
     * @param string $file
     * @return array|mixed
     */
    private static function parseFile($file)
    {
        switch (self::getExtension($file))
        {
            case "json":
                return json_decode(self::getFileContent($file));
                break;
            case "yml":
                return Yaml::parse(self::getFileContent($file));
                break;
            default:
                return [];
        }
    }

}