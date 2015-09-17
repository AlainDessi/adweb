<?php

namespace Core\Database;

/**
 * Class DataBase - Connexion à la base de données
 *
 * MySQL verion 5.6.17
 * PHP version 5.5.12
 *
 * @author      DESSI Alain <alain.dessi@laposte.net>
 * @copyright   2015 Dessi Alain
 * @license     http://www.php.net/license/3_01.txt  PHP License 3.01
 */


class Database
{

  private $db_host;
  private $db_user;
  private $db_pass;
  private $db_name;
  private $db_charset;

  private $link_db;


  /**
   * Initialise les valeurs de connexions de la base de donnée
   *
   * @param strng $host
   * @param strng $user
   * @param strng $pass
   * @param strng $dbname
   */
  function __construct( $host, $user, $pass, $dbname, $charset )
  {
      $this->db_host    = $host;
      $this->db_user    = $user;
      $this->db_pass    = $pass;
      $this->db_name    = $dbname;
      $this->db_charset = $charset;
  }


  /**
   * Ouverture base de données
   */
  public function db_open()
  {
      if( $this->link_db === null )
      {
          $pdo = new \PDO( "mysql:dbname={$this->db_name};host={$this->db_host}", $this->db_user, $this->db_pass );
          $pdo->exec("set names utf8");
          $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

           $this->link_db = $pdo;
      }
      return $this->link_db;
  }


  /**
   * envoi une requete à Mysql
   *
   * @param  string $sql requete sql
   * @param  string $class_name
   * @param  boolean $one_rec
   *
   * @return mixed Résultat de la requete
   */
  public function db_query( $sql, $class_name, $one_rec=false )
  {
      $req = $this->db_open()->query($sql);
      $req->setFetchMode(\PDO::FETCH_CLASS, $class_name);

      if($one_rec)
      {
          $data = $req->fetch();
      }
      else
      {
          $data = $req->fetchAll();
      }
      return $data;
  }


  /**
   * Execute une requete sql ( sans retour )
   *
   * @param  string $sql Requete SQL
   */
  public function db_exec($sql)
  {
      $req = $this->db_open()->exec($sql);
  }


  /**
   * Insère une ligne dans une table
   *
   * @param  string   $table_name
   * @param  array    $set_fields
   * @param  string   $class
   *
   * @return  mixed   renvoi false en cas d'erreur sinon renvoi l'id de l'enregistrement
   */
  public function db_insert($table_name, $set_fields)
  {
      $sql = "INSERT INTO `$table_name` ";

      $fields = '(';
      $values = 'VALUES (';

      foreach ($set_fields as $key => $value)
      {
          $fields .= " `$key`,";
          $values .= " :$key,";
          $value_exec[':'.$key] = $value;
      }

      $fields = substr($fields,0,strlen($fields)-1);
      $values = substr($values,0,strlen($values)-1);

      $fields .= " ) ";
      $values .= " ) ";

      $sql = $sql.$fields.$values;

      $req = $this->db_open()->prepare( $sql );
      $req->execute( $value_exec );

      if($req)
      {
          // recupere l'ID de l'enregistrement crée
          $req = $this->db_open()->lastInsertId();
      }

      return $req;
  }


  /**
   * Efface une ligne de la table
   *
   * @param  string $table
   * @param  string $class_name
   * @param  array $conditions
   *
   * @return boolean
   */
  public function db_delete($table, $class_name, $conditions)
  {
      $condition = "";

      foreach ($conditions as $key => $value)
      {
          $condition .= "`$key`=:$key AND ";
          $value_exec[':'.$key] = $value;
      }

      $condition = substr($condition,0,strlen($condition)-4);

      $sql = "DELETE FROM $table WHERE $condition ;";

      $req = $this->db_open()->prepare( $sql );

      return $req->execute( $value_exec );
  }


  /**
   * truncate table
   *
   * @param  string $table
   */
  public function db_truncate($table)
  {
      $sql = "TRUNCATE TABLE `$table` ";
      return $this->db_open()->query($sql);
  }


  /**
   * Récupére les nom de colonne d'une table
   *
   * @param  string   $table        Nom de la table
   * @param  string   $class_name   Nom de la classe
   *
   * @return object   Liste des colonnes
   */
  public function db_showcolumns($table, $class_name)
  {
      $sql = "SHOW COLUMNS FROM $table ;";
      return \Config::GetDb()->db_query( $sql, $class_name);
  }


  /**
   * Update query mysql ( more keys )
   *
   * @param  array    $condition    tableau des condition Where ( [ 'key_id' => 'value', ... ])
   * @param  array    $set_fields   tableau des colonnes à mettre à jour
   * @param  string   $table_name   Nom de la table
   *
   * @return  boolean
   */
  public function db_update($condition, $set_fields, $table_name)
  {
      $sql = "UPDATE `$table_name` SET ";

      $fields = '(';
      $values = 'VALUES (';

      // creation des valeurs
      foreach ($set_fields as $key => $value)
      {
          $sql .= " `$key`=:$key,";
          $value_exec[':'.$key] = $value;
      }

      // suppression de la dernière virgule
      $sql = substr($sql,0,strlen($sql)-1);
      $sql .= " WHERE ";

      // creation des conditions (where)
      foreach ( $condition as $key_id => $value_id )
      {
          $value_exec[ ':' . $key_id ] = $value_id;
          $sql .= " `$key_id`=:$key_id AND";
      }

      // suppression de la dernière virgule
      $sql = substr( $sql, 0, strlen($sql)-3 );

      // envoi de la requete préparé
      $req = $this->db_open()->prepare( $sql );

      // execution de la requete
      $req->execute( $value_exec );

      return $req;
  }

} // end class
