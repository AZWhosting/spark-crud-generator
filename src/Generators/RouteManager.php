<?php
// file: spark-crud-generator/src/Generators/RouteManager.php
namespace SparkCrudGenerator\Generators;

use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\Services\TemplateRenderer;

/**
 * Class RouteManager
 *
 * 🇬🇧 Manages route injection from route.tpl to Config/Routes.php
 * 🇫🇷 Gère l'injection des routes depuis route.tpl dans Config/Routes.php
 */
class RouteManager
{
    protected string $entity;
    protected string $routeBase;
    protected TemplateRenderer $renderer;

    /**
     * Constructor
     *
     * @param string           $entity
     * @param string           $routeBase
     * @param TemplateRenderer $renderer
     */
    public function __construct(string $entity, string $routeBase, TemplateRenderer $renderer)
    {
        $this->entity     = $entity;
        $this->routeBase  = $routeBase;
        $this->renderer   = $renderer;
    }

    /**
     * Propose to add missing routes, or display them for manual copy.
     *
     * 🇬🇧 Offers automatic route injection or fallback to manual copy.
     * 🇫🇷 Propose une injection automatique des routes ou un affichage manuel.
     *
     * @return void
     */
    public function handle(): void
    {
        $routesFile   = APPPATH . 'Config/Routes.php';
        $routeMarker  = "// [AUTO-CRUD] {$this->entity}";
        
        $routeContent = $this->renderer->render('route.tpl', [
            'entity'     => $this->entity,
            'routeBase'  => $this->routeBase,
        ]);

        $tplLines     = explode("\n", $routeContent);
        $existing     = is_file($routesFile) ? file_get_contents($routesFile) : '';

        $missingLines = array_filter($tplLines, fn($line) =>
            trim($line) !== '' && strpos($existing, trim($line)) === false
        );

        $add = CLI::prompt(lang('CrudGenerator.askAutoRoutes') . ' (y/n)', ['y', 'n']) === 'y';

        if ($add && !is_writable($routesFile)) {
            CLI::error("❌ Routes.php is not writable.");
            $add = false;
        }

        if ($add && !empty($missingLines)) {
            copy($routesFile, $routesFile . '.bak');

            // Nettoyage de l'existant
            $existing = rtrim($existing);

            // Nettoyage et assemblage sans double sauts
            $cleanLines = array_map('trim', $missingLines);
            $block = PHP_EOL . $routeMarker . PHP_EOL . implode(PHP_EOL, $cleanLines);

            file_put_contents($routesFile, $existing . $block . PHP_EOL);
            CLI::write("✅ Routes added to Config/Routes.php", 'green');
        }

        if (! $add || empty($missingLines)) {
            if (empty($missingLines)) {
                CLI::write("ℹ️ All routes for {$this->entity} already exist.", 'yellow');
            } else {
                CLI::write(lang('CrudGenerator.routesReminder'), 'blue');
                foreach ($missingLines as $line) {
                    CLI::write($line);
                }
            }
        }
    }
}
