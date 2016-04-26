<?php

namespace Core\Services;

class Files
{

    /**
     * [$path_dir description]
     * @var [type]
     */
    public $path_dir;


    /**
     * Lecture d'un répertoire
     * @param [type] $dir [description]
     */
    public static function ReadDir($dir)
    {
        return glob($dir.'*.*');
    }

    /**
     * ajoute un répertoire Media
     * @param String $dir_name
     */
    public static function CreateMediaDir($dirname)
    {
        $dir = MEDIA_DIR . $dirname;
        $path = self::CreateDir($dir);

        return $path;

    }

    /**
     * Crée un répertoire avec les droits maximum est renvoi le chemin
     * @param string $path
     */
    public static function CreateDir($path)
    {
        // test de l'existance du dossier
        if (!is_dir($path)) {
          // création directory
            if (!mkdir($path, 0777)) {
                return false;
            }
        }
        return $path;
    }

}
