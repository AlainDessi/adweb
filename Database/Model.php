<?php

namespace Core\Database;

use Core\Config;

class Model
{

  /**
   * Nom de la table
   * @var string
   */
	protected static $table;

  /**
   * Champs modifiable ( fillable )
   * @var array
   */
  protected $fillable;

  /**
   * Constructor Static
   */
  public static function __callStatic($method, $arguments)
  {
      $class = get_called_class();
      $dbtable = new $class;

      $query = new QueryBuilder( $dbtable->fillable );
      $query->from(self::GetTable());
      $query->setModel(get_called_class());

      return call_user_func_array([$query, $method], $arguments);
  }

	/**
	 * Récupére le nom de la table
	 */
	private static function GetTable()
  {
		  return strtolower(str_replace('App\Model\\', '', get_called_class()));
	}

} // end of class
