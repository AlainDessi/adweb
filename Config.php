<?php
 /**
  * Buscobon
  * Accès aux variables de configuration générale
  *
  * @author    	DESSI Alain <alain.dessi@laposte.net>
  * @copyright 	2015 Dessi Alain
  * @link      	http://www.alain-dessu.com
  */

namespace Core;

use Core\Database\Database;
use Core\Exceptions\ConfigException;

class Config {

    /**
     * Chemin des fichiers de configuration
     */
    const CONFIG_PATH = CONFIG_DIR;

    /**
     * [$database description]
     * @var [type]
     */
		private static $database;

    /**
     * [$emailconfig description]
     * @var [type]
     */
    private static $emailconfig;

    /**
     * [$_instance description]
     * @var [type]
     */
		private static $_instance;

    /**
     * [$settings description]
     * @var array
     */
		private $settings = array();


	/**
	 * récupére la configuration du logiciel
	 */
	private function __construct()
  {
      $files = glob(self::CONFIG_PATH . '*.config.php');

      foreach ($files as $file)
      {
          $name_file = str_replace(['.config.php', self::CONFIG_PATH], '', $file);
          $this->settings[$name_file] = require($file);
      }
	}

	/**
	 *  Instancifie une seule fois la config
	 */
	public static function GetConfig()
  {
		if( is_null(self::$_instance))
    {
			 self::$_instance = new Config();
		}

    return self::$_instance;
	}

  /**
   * ALIAS de GetSet($namesetting)
   * Renvoi la valeur de configuration spécifié
   *
   * @param  string $namesetting contient également le nom du fichier de config ( exemple 'button.save' )
   *
   * @return mixed
   */
  public static function get($namesetting)
  {
      return self::GetSet($namesetting);
  }

	/**
	 * Renvoie une valeur de variable de configuration
   *
   * @param  string $namesetting contient également le nom du fichier de config ( exemple 'button.save' )
   *
   * @return mixed
   */
	public static function GetSet($name_setting)
  {
      $args = explode('.', $name_setting,2);


      // initialisation de la configuration
      if(!empty($args[1]))
      {
          $group = $args[0];
          $name_setting = $args[1];
      }
      else
      {
          $group = 'user';
          $name_setting = $args[0];
      }

      $set = self::GetConfig();

      // récuprération de la valeur de configuration
      if(isset($set->settings[$group][$name_setting]))
      {
          return $set->settings[$group][$name_setting];
      }
      else
      {
          return null;
      }
	}

		/**
		 * Initialise et retourne la base de donnée
		 */
  public static function GetDb()
  {
      if(self::$database == null)
      {
          $instance = self::GetConfig();
	   			self::$database = new Database( $instance->settings['user']['db_host'], $instance->settings['user']['db_user'], $instance->settings['user']['db_password'], $instance->settings['user']['db_name'], $instance->settings['user']['db_charset'] );
			}
			return self::$database;
	}

    /**
     * Instance de PHPMailer
     * @return [type] [description]
     */
    public static function getMail()
    {

      $params = \Params::get();

      if(self::$emailconfig == null) {

        $instance = self::GetConfig();

        self::$emailconfig = new PHPMailer;

        self::$emailconfig->isSMTP();
        self::$emailconfig->isHTML(true);

        self::$emailconfig->Host        = $instance->settings['Host'];
        self::$emailconfig->SMTPAuth    = $instance->settings['SMTPAuth'];
        self::$emailconfig->Username    = $instance->settings['Username'];
        self::$emailconfig->Password    = $instance->settings['Password'];
        self::$emailconfig->SMTPSecure  = $instance->settings['SMTPSecure'];
        self::$emailconfig->Port        = $instance->settings['Port'];

        self::$emailconfig->setFrom('alain.dessi@laposte.net', 'Sous L\'olivier');
        self::$emailconfig->From = 'sous l\'olivier';
        self::$emailconfig->CharSet = $instance->settings['CharSet'];
        self::$emailconfig->CharSet = $instance->settings['CharSet'];
        self::$emailconfig->addCC($params->owner_email);

        self::$emailconfig->addAddress('alain.dessi@laposte.net', 'DESSI Alain');

      }

      return self::$emailconfig;
    }

	} // End of class