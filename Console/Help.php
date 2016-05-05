<?php

namespace Core\Console;

class Make extends Console
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
        echo "utilisation : adweb [command] ... [elements] \n";
        echo "Tools for buscobon framework \n";
        echo "\n";
        echo "commands list \n";
        foreach ($commandList as $command) {
            echo "  - " . $command . "\n";
        }
    }
}
