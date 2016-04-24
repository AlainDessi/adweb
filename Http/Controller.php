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
        if(is_null($viewsDir)) {
            if(isset(VIEWS_DIR)) {
                $this->path_views = VIEWS_DIR;
            } else {
                $this->path_views = "";
            }
        } else {
            $this->path_views = $viewsDir;
        }

        if(is_null($cacheDir)) {
            if(isset(VIEWS_DIR)) {
                $this->path_cache = CACHE_DIR;
            } else {
                $this->path_cache = "";
            }
        } else {
            $this->path_cache = $cacheDir;
        }

    }

    /**
     * Génerateur de page (Obsolet)
     * @param  string  $page_name Nom de la page
     * @param  array   $data
     * @return
     */
    public function render($page_name, $data = null)
    {
        if ($data != null) {
            extract($data);
        }
        include($this->path_views . $page_name . '.php');
    }

    /**
     * Rendu de vue Blade
     * @param  string  $page Nom de la page
     * @param  array   $data
     * @return string
     */
    public function RenderBlade($page, $data = null)
    {
        $blade = new Blade($this->path_views, $this->path_cache);

        if (is_null($data)) {
            echo $blade->view()->make($page)->render();
        } else {
            echo $blade->view()->make($page, $data)->render();
        }
    }
}
