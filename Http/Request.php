<?php

namespace Core\Http;

class Request
{
    /**
     * Retourne les données de _POST après les avoir traités
     * @return array
     */
    public static function post($model = null)
    {
        // netoyage des données de post
        foreach ($_POST as $key => $value) {
            $type = gettype($_POST[$key]);
            if ($type === 'string') {
                $_POST[$key] = htmlspecialchars($value);
            }
            if ($_POST[$key] === 'on') {
                $_POST[$key] = 1;
            }
        }
        // récupération des données posté en entête http
        if (!is_null($model)) {
            // récupération des champs du modele
            $fillable = call_user_func($model . '::getFillable');
            foreach ($fillable as $value) {
                if (isset($_SERVER['HTTP_' . strtoupper($value)])) {
                    $_POST[$value] = $_SERVER['HTTP_' . strtoupper($value)];
                }
            }
        }
        return $_POST;
    }

    /**
     * retourne vrai ou faux si l'entente http est de type json
     * @method isJson
     * @return boolean
     */
    public function isJson()
    {
        if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check is an ajax request
     * @return boolean
     */
    public function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

            return true;
        } else {
            return false;
        }
    }
}
