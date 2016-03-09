<?php

namespace Core\Console;

class Migrate extends Console
{
    /**
     * Execute la commande d'affichage des routes de l'application
     * @return string
     */
    public function executeCommand()
    {
        $filename = $this->getFileName();

        if ($filename) {
            $file = ROOT_DIR . '/bdd/migration/' . $filename . '.sql';
        } else {
            $this->error(" Error : use adweb migrate <filename>");
            exit();
        }

        if (file_exists($file)) {
            $migrate = new \Core\Database\Migration();
            $migrate->Migrate($file);
            $this->success(" Success migrate Table : '$filename'");
            exit();
        } else {
            $this->error(" Error migration '$file' not found ! ");
            exit();
        }

        exit();
    }
}
