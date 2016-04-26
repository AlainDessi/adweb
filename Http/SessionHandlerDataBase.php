<?php

namespace Core\Http;

use Core\Config;

class SessionHandlerDataBase implements \SessionHandlerInterface
{
    /**
     * Durée de session en ms
     * @var integer
     */
    public $session_time = 7200; // default value 2 heures

    /**
     * Instance de Database
     * @var instance
     */
    public $db;

    /**
     * link db
     * @var instance
     */
    public $link_db;

    /**
     * Nom de la table de session
     * @var string
     */
    public $session_table;

    /**
     * Constructeur, initialise la base de données
     * @method construct
     */
    public function __construct($session_table = "sessions")
    {
        $this->session_table = $session_table;
        $this->db = Config::getDb();
    }

    /**
     * re-initialisation ou création de nouvelle session
     * @method open
     * @param  string $save_path
     * @param  string $session_name
     * @return boolean
     */
    public function open($save_path, $session_name)
    {
        $this->link_db = $this->db->db_open();
        $this->gc($this->session_time);
        return true;
    }

    /**
     * Ferme la session courante
     * @method close
     * @return boolean
     */
    public function close()
    {
        return true;
    }

    /**
     * Detruit une session
     * @method destroy
     * @param  string  $session_id
     * @return boolean
     */
    public function destroy($session_id)
    {
        $delete = $this->link_db->prepare("DELETE FROM " . $this->session_table . " WHERE session_id=?");
        return $delete->execute([$session_id]);
    }

    /**
     * Nettoie les vieilles sessions expirées
     * @method gc
     * @param  integer $maxlifetime
     * @return boolean
     */
    public function gc($maxlifetime)
    {
        $delete = $this->link_db->prepare('DELETE FROM ' . $this->session_table . ' WHERE session_expire<' . time());
        return $delete->execute();
    }

    /**
     * Lit les données d'une session depuis
     * le stockage et retourne le resultat
     * @method read
     * @param  string $session_id
     * @return string
     */
    public function read($session_id)
    {
        $sql = 'SELECT * FROM ' . $this->session_table . ' WHERE session_id=\'' . $session_id . '\'';
        $query = $this->link_db->prepare($sql);
        $query->execute();
        $session = $query->fetch(\PDO::FETCH_OBJ);
        if ($session) {
            return $session->session_data;
        } else {
            return false;
        }
    }

    /**
     * Ecrit les données de session dans le support de stockage
     * @method write
     * @param  string $session_id
     * @param  string $session_data
     * @return boolean
     */
    public function write($session_id, $session_data)
    {
        // definition de la durée avant expiration
        $session_expire = intval(time() + $this->session_time);

        // verification de session existante
        $sql = "SELECT COUNT(session_id) AS total
                FROM " . $this->session_table . " WHERE session_id='$session_id';";
        $query = $this->link_db->prepare($sql);
        $query->execute();
        $session = $query->fetch(\PDO::FETCH_OBJ);

        // session inexistante
        if (!$session || $session->total == 0) {
            // insertion de la session
            $insert = $this->link_db->prepare('INSERT INTO ' . $this->session_table . ' VALUES(?, ?, ?)');
            return $insert->execute([$session_id, $session_data, $session_expire]);
        } else {
            // mise à jour de la session
            $sqlUpdate = 'UPDATE ' . $this->session_table . '
                          SET session_data=\'' . $session_data . '\', session_expire=\'' . $session_expire . '\'
                          WHERE session_id=\'' . $session_id . '\';';
            return $this->link_db->exec($sqlUpdate);
        }
    }

    /**
     * Mise à jour du temps de session
     * @method setSessionTime
     * @param  integer  $session_time
     */
    public function setSessionTime($session_time)
    {
        if (gettype($session_time) === 'integer') {
            $this->session_time = $session_time;
        } else {
            return false;
        }
    }
}
