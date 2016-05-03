<?php

namespace Core\Console;

class Make extends Console
{

    private $type = [ 'controller',
                      'model',
                      'seedder' ];

    /**
     * Execute la commande d'affichage des routes de l'application
     * @return string
     */
    public function executeCommand()
    {
        if (count($this->args) > 0) {
            if (in_array($this->args[2], $this->type)) {
                call_user_func([$this, $this->args[2] . 'Builder'], []);
            } else {
                $this->error('Erreur impossible de créer un ' . $this->args[2]);
            }
        }
    }

    /**
     * [controllerBuilder description]
     * @method controllerBuilder
     * @param  [type]            $args [description]
     * @return [type]                  [description]
     */
    public function controllerBuilder($test = null)
    {
        if (isset($this->args[3])) {

            // définition du nom du controller
            $controller     = explode('/', $this->args[3]);
            $controllerName = end($controller);

            // suppression du nom du controller
            unset($controller[count($controller)-1]);

            // définition du path et du namespace
            $namespace      = implode('\\', $controller);
            $pathController = implode('/', $controller);

            // récupération du contenu du template
            ob_start();
              include TEMPLATE_DIR . 'controller.template.php';
            $page = ob_get_clean();

            // Création du chemin si inexistant
            $path = \Core\Services\Files::createDir(ROOT_DIR . '/app/Controller/' . $pathController);

            // création du fichier
            $handle = fopen($path . '/' . $controllerName . '.php', 'w');
            $save   = fwrite($handle, $page);
            fclose($handle);

            // résultat
            if (!$save) {
                $this->error('le controller n\'a pas pu être créée !');
            } else {
                $this->success($controllerName . ' créée avec succés');
            }
        } else {
            $this->error('Nom du controller manquant !');
        }
    }
}
