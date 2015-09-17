<?php

namespace Core\Services;


class Files {


	public $path_dir;


  /**
   * Lecture d'un répertoire
   * @param [type] $dir [description]
   */
	public static function ReadDir( $dir ) {

			return glob( $dir.'*.*' );

	}


  /* ajoute un répertoire Media */
  public static function CreateMediaDir( $dir_name )
  {
    $dir = MEDIA_DIR . $dir_name;
    $path = self::CreateDir($dir);

    return $path;

  }

  /**
   * Crée un répertoire avec les droits maximum est renvoi le chemin
   * @param [type] $path [description]
   */
  public static function CreateDir( $path )
  {
    // test de l'existance du dossier
    if ( !is_dir( $path )) {
      // création directory
      if ( !mkdir( $path, 0777 ) ) {
        return false;
      }
    }
    return $path;
  }

} // end class
