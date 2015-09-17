<?php
/**
 * BUSCOBON - PHP FRAMEWORK
 *
 * Fonctions système
 *
 * MySQL verion 5.5.43
 * PHP version 5.4.39-0
 *
 * @author    	DESSI Alain <alain.dessi@laposte.net>
 * @copyright 	2015 Dessi Alain
 * @link      	http://www.alain-dessi.com
 */

/**
 * Debug and Die
 *
 * @param  Mixed $var variable à debugger
 */
function debug( $var )
{
  var_dump($var);
  die();
}

/**
 * Write a url by is Alias
 *
 * @param  string $alias
 * @param  mixed $arguments
 * @return string
 */
function route( $alias, $arguments = null )
{
    $url = '/' . Routes::getUrlAlias($alias);

    if( gettype($arguments) === 'string' ) {
      $url .= '/' . $arguments;
    }
    elseif(gettype($arguments) === 'array')
    {
      $url .= '/' . implode('/',$arguments);
    }

    $url = str_replace('//', '/', $url);

    return $url;
}

  function View($alias, $args=null)
  {
    $url = str_replace('.', '/', $alias);
    $controller = new Core\Http\Controller();

    return $controller->RenderBlade($url,$args);
  }

  /**
   * Redirect to an alias
   *
   * @param  string $alias     [description]
   * @param  mixed $arguments [description]
   */
  function redirect( $alias, $arguments = null )
  {
    header('Location: ' . route($alias, $arguments));
  }


  /**
   * Creé un nom de fichier unique
   * utile pour le chargement et le stockage des photos
   *
   * @param [type] $filename [description]
   */
  function UniqFileName( $filename )
  {
    $newfilename = strtolower( $filename );
    $extension   = substr($newfilename, -3);
    $newfilename = uniqid() . '.' . $extension;

    return $newfilename;
  }

  /**
   * Envoi d'un mail ( utilise phpmailer )
   *
   * @param string $subject
   * @param string $body
   */
  function SendMail($subject,$body)
  {
    // initialisation du mail
    $mail = Config::getMail();

    $mail->Subject = $subject;
    $mail->Body    = $body;

    return $mail->send();
  }

  /**
   * Récupére et renvoi un modele de mail
   *
   * @param  string $filename
   * @param  array $data
   * @return string
   */
  function getMailBody( $filename, $data )
  {
    extract($data);

    ob_start();
    require( MODELS_DIR . '/' . $filename );
    $body = ob_get_contents();
    ob_end_clean();

    return $body;
  }



  /**
   * Fonction d'affichage d'erreur fatale PHP
   *
   */
  function shutDownFunction()
  {
    $returnederror = error_get_last();

    if(!is_null($returnederror)) {

      $arrayerror[0] = $returnederror['type'];
      $arrayerror[1] = $returnederror['message'];
      $arrayerror[2] = $returnederror['file'];
      $arrayerror[3] = $returnederror['line'];

      $error = new Core\Debug\PhpErrors($arrayerror);
      return $error->View();
    }
  }



/**
 * Fonction d'affichage des erreur PHP
 */
function Error()
{
  $returnederror = func_get_args();
  $error = new Core\Debug\PhpErrors($returnederror);
  return $error->View();
}

/**
 * Fonction d'affichage des exeptions orphelines
 * @param [type] $exeption [description]
 */
function ExeptionError($exeption)
{
  $error = new Core\Debug\ExeptionErrors($exeption);
  return $error->View();
}

/**
 * Fonction d'affichage des pages d'erreur Http
 *
 * @param string $error nom de la page http d'erreur
 */
function HttpError($error)
{
  return View('errors.' . $error);
}
