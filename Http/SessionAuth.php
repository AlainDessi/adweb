<?php

namespace Core\Http;

use App\Model\Rights;
use App\Model\Users;

class SessionAuth extends Session
{
    /**
     * Constructeur
     */
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * Place l'ID de l'utilisateur dans la session
     * @param int $userId
     * @return instance
     */
    public function setId($userId)
    {
        $this->put('Auth', 'id', $userId);
        return $this;
    }

    /**
     * Place l'email de l'utilisateur dans la session
     * @param string $email
     * @return instance
     */
    public function setEmail($email)
    {
        $this->put('Auth', 'email', $email);
        return $this;
    }

    /**
     * Place les droits de l'utilisateur dans la session
     * @param int $right
     * @return instance
     */
    public function setRight($right)
    {
        $this->put('Auth', 'right', $right);
        return $this;
    }

    /**
     * Retourne l'id de l'utilisateur
     * @return int
     */
    public function getId()
    {
        return $this->get('Auth', 'id');
    }

    /**
     * Retourne l'email de l'utilisateur
     * @return string
     */
    public function getEmail()
    {
        return $this->get('Auth', 'email');
    }

    /**
     * Retourne les droits de l'utilisateur
     * @return int
     */
    public function getRight()
    {
        return $this->get('Auth', 'right');
    }

   /**
    * Vérification de l'utilisiteur est bien loggé
    * @return boolean
    */
    public function hasLogged()
    {
        if (isset($_SESSION['Auth'])) {
            return true;
        } else {
            return false;
        }
    }

   /**
    * Vérifie si l'utilisateur est bien loggué
    * @return redirect
    */
    public function check()
    {
        if (!$this->hasLogged()) {
            redirect('login');
        }
    }

    /**
     * Déconnecte l'utilisateur en supprimant
     * la session relative à l'authentification
     * @return boolean
     */
    public function logout()
    {
        unset($_SESSION['Auth']);
        return true;
    }

    /**
     * Retourne le nom du droit de l'utilisateur
     * @return string
     */
    public function rightName($right)
    {
        return Rights::getTitle($right);
    }
}
