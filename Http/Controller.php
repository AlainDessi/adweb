<?php
declare(strict_types=1);

namespace Core\Http;

use Core\Config;
use Jenssegers\Blade\Blade;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;

class Controller
{
    private string $path_views;
    private string $path_cache;

    /** Instance Blade unique réutilisée pour tout le process */
    private static ?Blade $blade = null;

    public function __construct(?string $viewsDir = null, ?string $cacheDir = null)
    {
        $this->path_views = $viewsDir ?? VIEWS_DIR;
        $this->path_cache = $cacheDir ?? CACHE_DIR; // (fix: plus d’erreur d’affectation)

        if (!is_dir($this->path_cache)) {
            @mkdir($this->path_cache, 0o775, true);
        }
    }

    /** Retourne l’unique instance Blade configurée sur tes chemins */
    private function blade(): Blade
    {
        if (self::$blade === null) {
            self::$blade = new Blade($this->path_views, $this->path_cache);
        }
        return self::$blade;
    }

    /** Données partagées disponibles dans toutes les vues */
    protected function sharedViewData(): array
    {
        return [
            'session' => [
                'hasmsg' => \Session::hasMsg(),
                'msg'    => \Session::printMsg(),
            ],
        ];
    }

    /**
     * Rendu Blade (Jenssegers).
     * On bascule le container Illuminate sur celui de Blade le temps du rendu,
     * pour que app('blade.compiler') et les Facades résolvent correctement.
     */
    public function renderBlade(string $page, ?array $data = null): void
    {
        $blade = $this->blade();
        $data  = array_merge($this->sharedViewData(), $data ?? []);

        // Sauvegarde l’état courant
        $bladeContainer    = $blade->getContainer();
        $prevContainer     = Container::getInstance();
        $prevFacadeApp     = method_exists(Facade::class, 'getFacadeApplication')
                             ? Facade::getFacadeApplication()
                             : null;

        // Bascule sur le container de Blade
        Container::setInstance($bladeContainer);
        if (method_exists(Facade::class, 'setFacadeApplication')) {
            Facade::setFacadeApplication($bladeContainer);
        }

        try {
            echo $blade->make($page, $data)->render();
        } finally {
            // Restaure le container/facades d’avant
            if ($prevContainer) {
                Container::setInstance($prevContainer);
            }
            if (method_exists(Facade::class, 'setFacadeApplication')) {
                Facade::setFacadeApplication($prevFacadeApp);
            }
        }
    }

    /** Rendu PHP “vanilla” */
    public function render(string $page, ?array $data = null): void
    {
        if ($data) { extract($data, EXTR_SKIP); }
        include $this->path_views . $page . '.php';
    }

    /**
     * Sélecteur de moteur.
     * Par défaut: Blade. (Twig retiré)
     */
    public function renderTemplate(string $page, ?array $data = null): void
    {
        $type = (string) (Config::get('render') ?? 'blade');

        if ($type === 'php') {
            $this->render($page, $data);
        } else { // 'blade' par défaut
            $this->renderBlade($page, $data);
        }
    }

    /** CORS utilitaire */
    public function cors(): void
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');

        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
            exit();
        }
    }
}
