<?php

namespace Core\Http;

use Core\Config;
use Philo\Blade\Blade;
use Core\Http\Request;

class Controller {

  /**
   * Path des vues
   * @var [type]
   */
  private $path_views;

  private $path_cache;


	public function __construct() {

    $this->path_views = VIEWS_DIR;
    $this->path_cache = CACHE_DIR;

	}

	/**
	 * Génerateur de page
   *
	 * @param  string  $page_name Nom de la page
	 * @param  array   $data
	 */
	public function render( $page_name, $data=null )
  {
  		if( $data != null ) {
  			extract($data);
  		}

      // message de retour
  		/*echo self::getmsgbox();*/

      // page
  		include($this->path_views . $page_name . '.php');
	}

  /**
   * Rendu de vue Blade
   *
   * @param  string  $page Nom de la page
   * @param  array   $data
   */
  public function RenderBlade($page,$data=null)
  {
      $blade = new Blade($this->path_views, $this->path_cache);

      if(is_null($data)) {
        echo $blade->view()->make($page)->render();
      }
      else {
        echo $blade->view()->make($page,$data)->render();
      }
  }

} // end of class
