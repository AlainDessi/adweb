<?php


/**
 * BUSCOBON - PHP FRAMEWORK
 *
 * Initialisation du mode developpement
 *
 * PHP 5.5.12
 * @author  alain DESSI <alain.dessi@laposte.net>
 * @link    www.alain-dessi.com
 *
 */

// création du fichier de log si n'existe pas
Core\Services\Files::CreateDir( dirname(__DIR__) . '/temp/logs');

// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', true);

// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__DIR__) . '/temp/logs/log_error_php.txt');

// Afficher les erreurs et les avertissements
error_reporting(E_ALL);

// define exeption handler
set_exception_handler('ExeptionError');

// define error handle
set_error_handler('Error');

// define shutdown function
register_shutdown_function('shutdownFunction');

// Affichage des erreurs
ini_set('display_errors', false);
