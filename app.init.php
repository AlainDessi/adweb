<?php
/**
 * BUSCOBON - PHP Framework
 *
 * Initialisation de l'application
 *
 * @author    	DESSI Alain <alain.dessi@laposte.net>
 * @copyright 	2015 Dessi Alain
 * @link      	http://www.alain-dessi.com
 */

// version et release
define( 'VERSION', 'V0.1 Alpha');

//define répertoire de l'application
define( 'ROOT_DIR'	, dirname(__DIR__) );
define( 'VIEWS_DIR'	, ROOT_DIR . '/resources/views/' );
define( 'CACHE_DIR' , ROOT_DIR . '/temp/cache/' );
define( 'CONFIG_DIR', ROOT_DIR . '/config/');

// Set Time Zone
date_default_timezone_set('Europe/Paris');

// Functions de l'application
require_once (__DIR__ . '/app.functions.php');

// Debug
require_once(__DIR__ . '/app.debugmode.php');

// chargement des routes de l'application
require_once (dirname(__DIR__) . '/app/routes.php');
