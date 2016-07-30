<?php

namespace Core\Http;

use Core\Config;
use Philo\Blade\Blade;
use Core\Http\Request;

class Controller
{
    /**
     * Chemin des vues de l'application
     * @var string
     */
    private $path_views;

    /**
     * Chemin du cache de l'application
     * @var string
     */
    private $path_cache;

    /**
     * Constructeur
     * @param string $viewsDir
     * @param string $cacheDir
     */
    public function __construct($viewsDir = null, $cacheDir = null)
    {
        if (is_null($viewsDir)) {
            $this->path_views = VIEWS_DIR;
        } else {
            $this->path_views = $viewsDir;
        }

        if (is_null($cacheDir)) {
            $this->path_cache = CACHE_DIR;
        } else {
            $this->path_views = $cacheDir;
        }
    }

    /**
     * Génerateur de page PHP
     * @param  string  $page
     * @param  array   $data
     */
    public function render($page, $data = null)
    {
        if ($data != null) {
            extract($data);
        }
        include($this->path_views . $page . '.php');
    }

    /**
     * Rendu de vue avec le moteur Laravel/Blade
     * @param  string  $page
     * @param  array   $data
     */
    public function renderBlade($page, $data = null)
    {
        $blade = new Blade($this->path_views, $this->path_cache);
        if (is_null($data)) {
            echo $blade->view()->make($page)->render();
        } else {
            echo $blade->view()->make($page, $data)->render();
        }
    }

    /**
     * Rendu de page avec le moteur TWIG
     * @method renderTwig
     * @param  string     $page
     * @param  array      $data
     */
    public function renderTwig($page, $data = null)
    {
        // modification du nom du template pour twig
        $page = $page . '.twig';
        $loader = new \Twig_Loader_Filesystem($this->path_views);
        $twig   = new \Twig_Environment($loader, array(
            'cache'         => $this->path_cache,
            'debug'         => \Core\Config::get('twig.debug'),
            'auto_reload'   => \Core\Config::get('twig.auto_reload')
        ));

        // Création de données pour twig
        $add_data = [
            'session' => [
                'hasmsg'    => \Session::hasMsg(),
                'msg'       => \Session::printMsg()
            ]
        ];

        // ajout des données de session pour twig
        if (is_null($data)) {
            $data = $add_data;
        } else {
            array_merge($data, $add_data);
        }

        // affichage de la page
        echo $twig->render($page, $data);
    }

    /**
     * Rendu de page html
     * @method renderTemplate
     * @param  string         $page
     * @param  array          $data
     */
    public function renderTemplate($page, $data = null)
    {
        $typeRender = \Core\Config::get('render');

        if (empty($typeRender) || $typeRender === 'blade') {
            $this->renderBlade($page, $data);
        } elseif (\Core\Config::get('render') === 'twig') {
            $this->renderTwig($page, $data);
        } elseif (\Core\Config::get('render') === 'php') {
            $this->render($page, $data);
        }
    }

    /**
     * Http Accept control Cors
     * @return [type] [description]
     */
    public function cors()
    {
        // définition des domaines autorisée à recevoir les données
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
            exit();
        }
    }
}
