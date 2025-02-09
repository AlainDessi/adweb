<?php

namespace Core\Debug;

use Core\Config;

Class Errors
{

  /**
   * message d'erreur
   * @var string
   */
  protected $message;

  /**
   * Détail de l'erreur
   * @var string
   */
  protected $content;

  /**
   * Fichier d'où provient l'erreur
   * @var string
   */
  protected $file;

  /**
   * Ligne d'où provient l'erreur
   * @var string
   */
  protected $line;

  /**
   * Nom de l'erreur
   * @var String
   */
  protected $error;


  /**
   * Affiche l'erreur
   */
  public function View()
  {
    $title = $this->message;
    include(__DIR__ . '/htmlmodel/default.php');
    die();
  }


} // end class
