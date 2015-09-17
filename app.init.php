<?php
/**
 * BUSCOBON - PHP Framework
 *
 * Initialisation de l'application
 *
 * @author      DESSI Alain <alain.dessi@laposte.net>
 * @copyright   2015 Dessi Alain
 * @link        http://www.alain-dessi.com
 */

// version et release
define( 'VERSION', 'V0.1 Alpha');

// Set Time Zone
date_default_timezone_set('Europe/Paris');

// Functions de l'application
require_once (__DIR__ . '/app.functions.php');

// Debug
require_once(__DIR__ . '/app.debugmode.php');

// chargement des routes de l'application
require_once (ROOT_DIR . '/app/routes.php');
