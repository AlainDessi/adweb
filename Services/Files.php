<?php

namespace Core\Services;

class Files
{
    /**
     * Lecture d'un répertoire
     * @param string $dir chemin à analyser
     * @return array
     */
    public static function readDir($dir)
    {
        return glob($dir.'*.*');
    }

    /**
     * Obsolete function : ajoute un répertoire Media
     * @param String $dir_name
     */
    public static function createMediaDir($dirname)
    {
        $dir = MEDIA_DIR . $dirname;
        $path = self::CreateDir($dir);

        return $path;
    }

    /**
     * Crée un répertoire avec les droits maximum est renvoi le chemin
     * @param string $path
     * @param integer $right  mode en base octale
     * @return string chemin du dossier ou false en cas d'erreur
     */
    public static function createDir($path, $right = 0777)
    {
        $directories = explode('/', $path);
        $currentPath = '';

        foreach ($directories as $dir) {
            $currentPath .= $dir . '/';
            // test de l'existance du dossier
            if (!is_dir($currentPath)) {
              // création directory
                if (!mkdir($currentPath, $right)) {
                    return false;
                }
            }
        }
        return $path;
    }
}
