<?php

namespace Core\Http;

use Alert;

class Session
{
    /**
     * Constructeur
     * Démarre une session si elle n'a pas déjà été démarré
     */
    public function __construct()
    {
        if (empty(session_id()) && is_null(session_id())) {
            session_start();
        }
    }

    /**
     * Ajoute une valeur dans la session
     * @param  string $group
     * @param  string $key
     * @param  string $value
     * @return Boolean
     */
    public function put($group, $key, $value)
    {
        $_SESSION[$group][$key] = $value;
        return $value;
    }

    /**
     * Alias de Put
     * @param  string $group
     * @param  string $key
     * @param  string $value
     * @return Boolean
     */
    public function setValue($group, $key, $value)
    {
        return self::put($group, $key, $value);
    }

    /**
     * Supprime une valeur de session
     * @param  string $group
     * @param  string $key
     * @return Boolean
     */
    public function unsetValue($group, $key = null)
    {
        if (empty($group)) {
            return false;
        }

        if (is_null($key)) {
            unset($_SESSION[$group]);
            return true;
        } else {
            unset($_SESSION[$group][$key]);
            return true;
        }
    }

    /**
     * Retourne une valeur de Session
     * @param  string $group
     * @param  string $key
     * @return string or False si erreur
     */
    public function get($group, $key = null)
    {
        if (isset($_SESSION[$group])) {
            if (is_null($key)) {
                return $_SESSION[$group];
            } else {
                if (isset($_SESSION[$group][$key])) {
                    return $_SESSION[$group][$key];
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * Ajoute un message dans une session
     * @param string $type (alert, warning, info, ...)
     * @param string $msg
     */
    public function setMsg($type, $msg)
    {
        $_SESSION['msg'][$type] = $msg;
    }

    /**
     * Ajoute un message de type Danger
     * @param  string $msg
     */
    public function danger($msg)
    {
        $this->setMsg('danger', $msg);
    }

    /**
     * Ajoute un message de type Warning
     * @param  string $msg
     */
    public function warning($msg)
    {
        $this->setMsg('warning', $msg);
    }

    /**
     * Ajoute un message de type Info
     * @param  string $msg
     */
    public function info($msg)
    {
        $this->setMsg('info', $msg);
    }

    /**
     * Ajoute un message de type Success
     * @param  string $msg
     */
    public function success($msg)
    {
        $this->setMsg('success', $msg);
    }

    /**
     * Verifie si un message est defini dans la session
     * @return  Boolean
     */
    public function hasMsg()
    {
        return isset($_SESSION['msg']);
    }

    /**
     * Efface un message dans la session
     * @return Boolean
     */
    public function clearMsg()
    {
        if (isset($_SESSION['msg'])) {
            unset($_SESSION['msg']);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Affiche le message contenu dans la session
     * Message de type Bootstrap
     * @return string formated html string or False si il n'a pas de message
     */
    public function printMsg()
    {
        if (isset($_SESSION['msg'])) {
            $html = '';
            foreach ($_SESSION['msg'] as $key => $value) {
                $html .= Alert::alert($key, $value) . "\n";
            }
            $this->clearMsg();
            return $html;
        } else {
            return false;
        }
    }
}
