<?php
/**
 * Création des routes et gestions des appels
 * Inspiré par le tutorial de Graphikart
 *
 * MySQL verion 5.5.43
 * PHP version 5.6.10
 *
 * @package     adweb/Buscobon MyFrameWork
 * @author      DESSI Alain <contact@alain-dessi.com>
 * @copyright   2016 Dessi Alain
 * @link        http://www.alain-dessi.com
 */

namespace Core\Routing;

class Route
{

  /**
   * chemin
   * @var string
   */
    private $path;

  /**
   * callable
   * @var string
   */
    private $callable;

  /**
   * Alias
   * @var [type]
   */
    private $alias;

  /**
   * params
   * @var array
   */
    private $matches = [];


  /**
   * __construct
   * @param string $path
   * @param string $callable
   */
    public function __construct($path, $callable, $alias)
    {
        $this->path     = trim($path, '/');
        $this->callable = $callable;
        $this->alias    = $alias;
    }

  /**
   * Verification de l'existance de la route
   * @param  string $url
   * @return boolean
   */
    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";

        if (!preg_match($regex, $url, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

  /**
   * Appel de la fonction correspondate au controller
   */
    public function call()
    {
        if (is_string($this->callable)) {
            $call_method = explode('@', $this->callable);
            $controller = 'App\Controller\\' . $call_method[0];
            $action = $call_method[1];

            if (method_exists($controller, $action)) {
                $get_controller = new $controller();
                return call_user_func_array([$get_controller, $action], $this->matches);
            }
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

  /**
   * retourne la valeur de path
   * @return  string
   */
    public function getPath()
    {
        return $this->path;
    }

  /**
   * retourne la valeur de callable
   * @return string
   */
    public function getCallable()
    {
        return $this->callable;
    }

  /**
   * Renvoi la valeur Alias
   * @return string
   */
    public function getAlias()
    {
        return $this->alias;
    }
}
