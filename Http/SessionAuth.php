<?php

namespace Core\Http;

use App\Model\Rights;
use App\Model\Users;

class SessionAuth extends Session
{

    /**
     * Constructeur - démarre une session
     * si inexistante
     * @method __construct
     */
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * Défini l'Id de l'utilisateur connecté
     * @method setId
     * @param  integer $UserId
     * @return instance
     */
    public function setId($UserId)
    {
        $this->put('Auth', 'id', $UserId);
        return $this;
    }

    /**
     * Définition de l'émail de l'utilisateur connecté
     * @method setEmail
     * @param  string $Email
     * @return instance
     */
    public function setEmail($Email)
    {
        $this->put('Auth', 'email', $Email);
        return $this;
    }

    /**
     * Définition des droits de l'utilisateur connecté
     * @method setRight
     * @param  integer  $right
     * @return instance
     */
    public function setRight($right)
    {
        $this->put('Auth', 'right', $right);
        return $this;
    }

    /**
     * Retourne l'id de l'utilisateur connecté
     * @method getId
     * @return integer
     */
    public function getId()
    {
        return $this->get('Auth', 'id');
    }

    /**
     * Retourne l'email de l'utilisateur connecté
     * @method getEmail
     * @return string
     */
    public function getEmail()
    {
        return $this->get('Auth', 'email');
    }

    /**
     * Retourne les droits de l'utilisateur
     * @method getRight
     * @return integer
     */
    public function getRight()
    {
        return $this->get('Auth', 'right');
    }

    /**
     * Verifié si un utilisateur est connecté
     * @method hasLogged
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
     * Redirige vers la page de login si pas connecté
     * @method check
     * @return redirect
     */
    public function check()
    {
        if (!$this->hasLogged()) {
            redirect('login');
        }
    }

    /**
     * Deconnecte un utilisateur
     * permet de supprimer la sessions et toutes les données
     * @method logout
     * @return boolean
     */
    public function logout()
    {
        // effacement de toutes les données de session
        $_SESSION = [];

        // effacement du cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        // destruction de la session
        session_destroy();

        // return provisoire
        return true;
    }

    /**
     * Retourne le nom du droit
     * @method rightName
     * @param  int  $right
     * @return string
     */
    public function rightName($right)
    {
        return Rights::getTitle($right);
    }
} // end class
