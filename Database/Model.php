<?php

namespace Core\Database;

use Core\Config;

class Model
{
    /**
     * Nom de la table (Obsolet)
     * @var string
     */
    protected static $table;

    /**
     * Nom de la table si different du nom de la classe
     * @var string
     */
    protected $tableName;

    /**
     * Champs modifiable ( fillable )
     * @var array
     */
    protected $fillable;

    /**
     * Champs à slugifier
     * @var array
     */
    protected $slugifiable = array();

    /**
    * Appel statique
    */
    public static function __callStatic($method, $arguments)
    {
        $class = get_called_class();
        $dbtable = new $class;

        // initialisation du QueryBuilder
        $query = new QueryBuilder($dbtable->fillable);
        // definition du nom de la table
        if (!empty($dbtable->tableName)) {
            $query->from($dbtable->tableName);
        } else {
            $query->from(self::GetTable());
        }
        $query->setModel(get_called_class());
        $query->setFieldstoSlugifier($dbtable->slugifiable);

        return call_user_func_array([$query, $method], $arguments);
    }

    /**
     * Récupére le nom de la table
     * @method getTable
     * @return string
     */
    private static function getTable()
    {
        return strtolower(str_replace('App\Model\\', '', get_called_class()));
    }

  /**
   * retourne le nombre d'enregistrement d'une table
   *
   * @return int
   */
    public static function count()
    {
        $count = self::select(['COUNT(*) as nbrec'])->first();
        return $count->nbrec;
    }
}
