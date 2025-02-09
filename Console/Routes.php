<?php

namespace Core\Console;

class Routes extends console
{

    private $lencell       = 50;
    private $lencellmethod = 8;
    private $lencellalias  = 60;

    /**
     * Execute la commande d'affichage des routes de l'application
     * @return string
     */
    public function executeCommand()
    {

        // récupération des routes de l'application
        require_once (ROOT_DIR . '/app/routes.php');

        $cadrecell = '+' . str_repeat("-", $this->lencell ) . '+' . str_repeat("-", $this->lencellmethod ) . '+'  . str_repeat("-", $this->lencellalias ) . '+' . str_repeat("-", $this->lencell ) . '+' . "\n";

        echo $cadrecell;
        echo '| URL ' . str_repeat(" ", $this->lencell - 5) . '| METHOD ' . str_repeat(" ", $this->lencellmethod - 8) . '| ALIAS ' . str_repeat(" ", $this->lencellalias - 7) .'| CALL ' . str_repeat(" ", $this->lencell - 6) . '|'  . "\n";
        echo $cadrecell;

        foreach (\Routes::getRoutes() as $method => $routes) {
            foreach ($routes as $route) {
                echo '| ' . $route->getPath() . str_repeat(' ', $this->lencell - strlen($route->getPath()) -1 );
                echo '| ' . $method . str_repeat(' ', $this->lencellmethod - strlen($method) -1 );
                echo '| ' . $route->getAlias() . str_repeat( ' ', $this->lencellalias - strlen($route->getAlias())-1);
                echo '| ' . $route->getCallable() . str_repeat(' ', $this->lencell - strlen($route->getCallable()) - 1 ) . '|' . "\n";
            }
        }

        echo $cadrecell;

        exit();
    }

}
