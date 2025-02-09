<?php

namespace Core\Console;

class Seeder extends Console
{
    /**
     * Execute la commande d'affichage des routes de l'application
     * @return string
     */
    public function executeCommand()
    {
        $filename = $this->getFileName();

        if ($filename) {
            $class = 'Bdd\seeder\\'.$filename;
        } else {
             $this->success(" Error : use adweb seeder <filename> ");
            exit();
        }

        if(class_exists($class)) {
            $class::run();
            $this->success("$filename - Seeder success");
        } else {
            $this->error(" La classe 'Bdd\seeder\\$filename.php' n'existe pas ");
        }


      exit();

    }
}
