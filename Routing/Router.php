<?php

namespace Core\Routing;

class Router
{

	/**
	 * router url
	 * @var string
	 */
	private $url;

	/**
	 * router url method
	 * @var string
	 */
	private $url_method;

	/**
	 * routes array
	 * @var array
	 */
	private $routes = [];

  /**
   * Lite des Alias
   * @var array
   */
  private $routesAlias = [];

  /**
   * Methodes d'une class controller par default
   * @var array
   */
  private $methods = [  '/index'      => 'GET',
                        '/edit/:id'   => 'GET',
                        '/update/:id' => 'POST',
                        '/create'     => 'GET',
                        '/store'      => 'POST',
                        '/delete/:id' => 'GET' ];

  /**
   * Constructeur
   *
   * @param [type] $url [description]
   */
	public function __construct( $url = null )
  {
      if(!empty($_GET['url']))
      {
          $url = $_GET['url'];
      }
      else
      {
          $url = '';
      }

  		if ( !empty( $url) || !is_null( $url ) )
      {
    			$this->url = $url;
          if(isset($_SERVER['REQUEST_METHOD']))
          {
              $this->url_method = $_SERVER['REQUEST_METHOD'];
          }
  		}
  		else
      {
  			 return false;
  		}
	} // end __construct

	public function get( $path, $callable, $alias = null )
  {
      return $this->addRoute( $path, $callable, $alias, 'GET' );
	}

  /**
   * Création d'une route en post
   *
   * @param  [type] $path     [description]
   * @param  [type] $callable [description]
   * @param  [type] $alias    [description]
   * @return [type]           [description]
   */
	public function post( $path, $callable, $alias = null )
  {
      return $this->addRoute( $path, $callable, $alias, 'POST' );
	}

  /**
   * Création automatique des routes d'un controller par default
   * @param  [type] $path      [description]
   * @param  [type] $callclass [description]
   * @return [type]            [description]
   */
  public function resource( $path, $callclass )
  {
      foreach ($this->methods as $method => $type) {

        $method_name = str_replace(['/',':','id'], '', $method);

        if($method_name == 'index') {
          $finalpath = $path;
          $alias = substr( str_replace('/', '.', $path), 1);
        }
        else {
          $finalpath = $path . $method;

          $alias = str_replace('/', '.', $method );
          $alias = substr( str_replace('/', '.', $path) . str_replace(':id', '', $alias ) , 1);

          if(substr( $alias , -1) == '.') {
            $alias = substr( $alias , 0, -1);
          }
        }

        $callable = $callclass . '@' . str_replace(['/',':','id'], '', $method);

        $this->addRoute($finalpath, $callable, $alias, $type);
      }
  }

  /**
   * Fonction d'ajout d'une route
   *
   * @param [type] $path     [description]
   * @param [type] $callable [description]
   * @param [type] $alias    [description]
   * @param [type] $type     [description]
   */
  private function addRoute( $path, $callable, $alias, $type )
  {

    if (is_null($alias)) {

      $alias = preg_replace('#/:[a-z]+#', '', $path);
      $alias = substr($alias,1);
      $alias = implode( '.', explode( '/', $alias ) );

    }

    $route = new Route( $path, $callable, $alias );
    $this->routes[$type][] = $route;

    $this->routesAlias[$alias] = $route;

    return $route;

  }

  /**
   * Démarrare le routeur
   * @return [type] [description]
   */
	public function run() {
    try {
      if ( !isset( $this->routes[ $this->url_method ] ) ) {
        throw new RouterException('REQUEST METHOD not exist');
      }

      // recherche de la route
  		foreach ($this->routes[ $this->url_method ] as $route ) {
  			if ( $route->match( $this->url ) ) {
  				return $route->call();
  			}
  		}

      // pas de route trouvé
      throw new RouterException('Aucune routes ne correspond à cette URL', '404');
    }

    catch(RouterException $e)
    {
      if(\Core\Config::get('dev')) {
        ExeptionError($e);
      }
      else {
        HttpError('404');
      }
    }

	}

  /**
   * Return value of routes
   * @return array
   */
  public function getRoutes()
  {
    return $this->routes;
  }

  /**
   * Renvoi la route par rapport à son alias
   *
   * @param  [type] $alias [description]
   * @return [type]        [description]
   */
  public function getRouteAlias($alias)
  {

    if(isset($this->routesAlias[$alias])) {
      return $this->routesAlias[$alias];
    }
    else {
      return false;
    }

  }

  /**
   * Renvoi l'url d'un Alias
   *
   * @param  [type] $alias [description]
   * @return [type]        [description]
   */
  public function getUrlAlias( $alias )
  {
    $route = $this->getRouteAlias($alias);
    if($route) {
      $path = $route->getPath();
      return preg_replace('#/:[a-z]+#', '', $path);
    }
    else {
      return 'no routes defined';
    }
  }

} // end class
