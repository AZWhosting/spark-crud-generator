<?php
// Path: spark-crud-generator/src/Generators/ControllerGenerator.php
namespace SparkCrudGenerator\Generators;

use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\Services\TemplateRenderer;

/**
 * Class ControllerGenerator
 *
 * 🇬🇧 Generates the controller file for the CRUD entity using a template.
 * 🇫🇷 Génère le fichier contrôleur pour l'entité CRUD à partir d’un template.
 */
class ControllerGenerator
{
    /**
     * @var string Entity name (e.g. Product)
     */
    protected string $entity;

    /**
     * @var TemplateRenderer Template engine instance
     */
    protected TemplateRenderer $renderer;

    /**
     * @var bool Whether to force overwrite
     */
    protected bool $force;

    /**
     * Constructor
     *
     * @param string            $entity   Entity name (e.g. Product)
     * @param TemplateRenderer  $renderer Template renderer instance
     * @param bool              $force    Whether to overwrite existing files
     */
    public function __construct(string $entity, TemplateRenderer $renderer, bool $force = false)
    {
        $this->entity  = $entity;
        $this->renderer = $renderer;
        $this->force   = $force;
    }

    /**
     * Generate the controller file.
     *
     * 🇬🇧 Builds the controller using controller.tpl.
     * 🇫🇷 Construit le contrôleur via controller.tpl.
     *
     * @return void
     */
    public function generate(): void
    {
        $className  = $this->entity . 'Controller';
        $viewPath   = strtolower($this->entity);
        //$routeBase  = strtolower(plural($this->entity));
        $routeBase  = strtolower($this->entity);
        $target     = APPPATH . "Controllers/{$className}.php";

        if (is_file($target) && ! $this->force) {
            $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', [$target]), ['y', 'n']) === 'y';
            if (! $overwrite) {
                CLI::write("❌ {$className}.php " . lang('CrudGenerator.skippedExisting'), 'yellow');
                return;
            }
        }

        $content = $this->renderer->render('controller.tpl', [
            'entity'     => $this->entity,
            'viewPath'   => $viewPath,
            'routeBase'  => $routeBase,
            'variableNamePlural' => lcfirst(plural($this->entity)),
        ]);


        write_file($target, $content);
        CLI::write("✅ " . lang('CrudGenerator.generated') . ": Controllers/{$className}.php", 'green');
    }
}
