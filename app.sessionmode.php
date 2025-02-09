<?php
/**
 * Gestion des sessions
 *
 * @category    initialisation
 * @package     adweb.buscobon
 * @author    	DESSI Alain <alain.dessi@laposte.net>
 * @copyright 	2016 Dessi Alain
 * @link      	http://www.alain-dessi.com
 */

// vérification du type de mode dans config
$session_mode = Core\Config::get('session_mode');
if (is_null($session_mode)) {
    $session_mode = 1;
}

// session mode Base de données
if ($session_mode === 2) {
    // récupération temps d'expiration
    $session_expire = Core\Config::get('session_time');
    if (is_null($session_expire)) {
        $session_expire = 7200;
    }
    // récuperation du nom de la table
    $session_table = Core\Config::get('session_tablename');
    if (is_null($session_table)) {
        $session_table = 'sessions';
    }
    // initialisation du handler
    $session = new Core\Http\SessionHandlerDataBase($session_table);
    $session->setSessionTime($session_expire);
    // Mise en place du handler
    ini_set('session.save_handler', 'user');
    session_set_save_handler($session);
    // démarage de session
    session_start();
} else {
    // démarage de session mode Normal
    session_start();
}
