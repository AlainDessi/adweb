<?php

namespace Core\Console;

class Help extends Console
{
    private $type = [ 'controller',
                      'model',
                      'seedder' ];

    /**
     * Execute la commande d'affichage de l'aide
     * @return string
     */
    public function executeCommand()
    {
        echo $this->instanceColor->StrColor('BUSCOBON Adweb', "green") . "\n";
        echo "utilisation : adweb [command] ... [elements] \n";
        echo "Tools for buscobon framework \n";
        echo "\n";
        echo "commands list: \n";
        foreach ($this->commandList as $command) {
            echo "  - " . $command . "\n";
        }
        echo "\n";
    }
}
