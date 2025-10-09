<?php
/**
 * BUSCOBON - PHP Framework
 * Initialisation des modules de démarrage
 *
 * @author      DESSI Alain <alain.dessi@laposte.net>
 * @copyright   2016-2017 Dessi Alain
 * @link        http://www.alain-dessi.com
 */

// version et release
define('VERSION', 'V1.0.0');

// Set Time Zone
date_default_timezone_set('Europe/Paris');

// Functions de l'application
require_once(__DIR__ . '/app.functions.php');

// Debug
require_once(__DIR__ . '/app.debugmode.php');

// session_mode
require_once(__DIR__ . '/app.sessionmode.php');

// chargement des routes de l'application
require_once(ROOT_DIR . '/app/routes.php');
