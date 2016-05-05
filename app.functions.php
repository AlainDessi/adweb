<?php
/**
 * Fonction utiles pour le framework
 * BUSCOBON - PHP FRAMEWORK
 *
 * PHP version 5.4.39-0
 *
 * @author      DESSI Alain <alain.dessi@laposte.net>
 * @copyright   2015 Dessi Alain
 * @link    http://www.alain-dessi.com
 */

/**
 * Debug and Die
 * @param  Mixed $var variable à debugger
 */
function debug($var)
{
    var_dump($var);
    die();
}

/**
 * UrlBuilder
 * Renvoi une url par rapport à
 * un alias et ses arguments
 * @param  string $alias
 * @param  mixed $arguments
 * @return string
 */
function route($alias, $arguments = null)
{
    // récupére l'url
    $url = '/' . Routes::getUrlByAlias($alias);

    // Gestion des arguments null !! attention aux routes avec plusieurs arguments
    if (is_null($arguments)) {
        $url = preg_replace('#:[a-z]+#', '', $url);
    }

    // ajoute les arguments à l'url
    if (gettype($arguments) === 'string') {
        $url = preg_replace('#:[a-z]+#', $arguments, $url);
    } elseif (gettype($arguments) === 'array') {
        foreach ($arguments as $value) {
            $url = preg_replace('#:[a-z]+#', $value, $url, 1);
        }
    }

    // netoyage des / au cas ou
    $url = str_replace('//', '/', $url);

    // retour de l'url complète
    return $url;
}

/**
 * execute la fonction RenderBlade
 * l'alias de la page est le chemin de la page à partir du dossier de vues
 * exemple : admin.post ( decomposition en chemin : VIEW_DIR/admin/post.blade.php )
 *
 * @method view
 * @param  string $alias
 * @param  array $args
 * @return view
 */
function view($alias, $args = null)
{
    $url = str_replace('.', '/', $alias);
    $controller = new Core\Http\Controller();
    return $controller->renderTemplate($url, $args);
}

/**
 * Redirect to an alias
 *
 * @param  string $alias     [description]
 * @param  mixed $arguments [description]
 */
function redirect($alias, $arguments = null)
{
    header('Location: ' . route($alias, $arguments));
}

/**
 * Creé un nom de fichier unique
 * utile pour le chargement et le stockage des photos
 *
 * @param [type] $filename [description]
 */
function UniqFileName($filename)
{
    $newfilename = strtolower($filename);
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
function SendMail($subject, $body)
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
function getMailBody($filename, $data)
{
    extract($data);

    ob_start();
    require(VIEWS_DIR . '/emails/' . $filename);
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

    if (!is_null($returnederror)) {
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

/**
 * truncate action on HTML strings
 * use Urodoz\Truncate\TruncateService;
 *
 * @return string
 */
function truncate($htmlString, $nbchar = 100)
{
    $truncateService = new Urodoz\Truncate\TruncateService();
    return $truncateService->truncate($htmlString, $nbchar);
}

/**
 * Fonction de test ( development )
 * @return [type] [description]
 */
function getRoutes()
{
    require __DIR__ . '/tests/routes.php';
    $test = Routes::getRoutes();
    var_dump($test);
}
