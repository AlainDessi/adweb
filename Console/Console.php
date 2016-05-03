<?php

namespace Core\Console;

use Core\Http\Router;

class Console
{
    /**
     * Arguments passé sur la console
     * @var array
     */
    protected $args;

    /**
     * Liste des commandes
     * @var array
     */
    protected $commandList = [
                          'migrate',
                          'seeder',
                          'routes',
                          'make'
                        ];

    /**
     * Instance de couleur
     * @var instance
     */
    protected $color;

    public function __construct($args)
    {
        $this->args = $args;

        // initialisation de l'instance color
        $this->initColor();
    }

    /**
     * Execute la commande ( fonction principale )
     * @return [type] [description]
     */
    public function run()
    {
        // vérification de l'existance d'une commande
        if (count($this->args) > 0) {
            unset($this->args[0]);

            if (!$this->chkCommand()) {
                $this->error(' Command not found ! ');
                exit();
            }

            // execute la class correspondate à la fonctions
            $exec = new $this->command($this->args);
            $exec->executeCommand();

        } else {
            error('aucune commande à executer');
        }
    }

    /**
     * Initialisation de la couleur
     * @return
     */
    private function initColor()
    {
        $this->instanceColor = new Color();
    }

    /**
     * Récupére la commande à executer
     * @return string
     */
    private function chkCommand()
    {
        for ($i=1; $i <= count($this->args); $i++) {
            if (in_array($this->args[$i], $this->commandList)) {
                $this->command = '\Core\Console\\' . ucfirst($this->args[$i]);
                unset($this->args[$i]);
                return true;
            }
        }
        return false;
    }

    public function getFileName()
    {
        foreach ($this->args as $value) {
            if (substr($value, 0, 1) != '-') {
                return $value;
            }
        }
        return false;
    }

    /**
     * Return formated string error
     * @param  string $stringError
     * @return string
     */
    protected function error($stringError)
    {
        echo $this->instanceColor->StrColor($stringError, "white", "red") . "\n";
        echo "type 'php adweb help' for help \n";
        exit();
    }

    /**
     * Return formated string success
     * @param  string $stringSuccess
     * @return echo
     */
    protected function success($stringSuccess)
    {
        echo $this->instanceColor->StrColor($stringSuccess, "green") . "\n";
    }
}
