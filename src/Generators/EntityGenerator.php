<?php

namespace SparkCrudGenerator\Generators;

use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\Services\TemplateRenderer;

/**
 * Class EntityGenerator
 *
 * 🇬🇧 Generates the entity file for the CRUD entity using a template.
 * 🇫🇷 Génère le fichier entité pour l'entité CRUD à partir d’un template.
 */
class EntityGenerator
{
    /**
     * @var string Entity name (e.g. Product)
     */
    protected string $entity;

    /**
     * @var array Fields from askFields()
     */
    protected array $fields;

    /**
     * @var TemplateRenderer
     */
    protected TemplateRenderer $renderer;

    /**
     * @var bool Whether to force overwrite
     */
    protected bool $force;

    /**
     * Constructor
     *
     * @param string           $entity   Entity name
     * @param array            $fields   Field definitions
     * @param TemplateRenderer $renderer Template engine
     * @param bool             $force    Force overwrite if exists
     */
    public function __construct(string $entity, array $fields, TemplateRenderer $renderer, bool $force = false)
    {
        $this->entity   = $entity;
        $this->fields   = $fields;
        $this->renderer = $renderer;
        $this->force    = $force;
    }

    /**
     * Generate the entity file.
     *
     * 🇬🇧 Builds the entity using entity.tpl.
     * 🇫🇷 Construit l’entité via entity.tpl.
     *
     * @return void
     */
    public function generate(): void
    {
        $className = $this->entity;
        $target    = APPPATH . "Entities/{$className}.php";

        if (is_file($target) && ! $this->force) {
            $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', [$target]), ['y', 'n']) === 'y';
            if (! $overwrite) {
                CLI::write("❌ {$className}.php " . lang('CrudGenerator.skippedExisting'), 'yellow');
                return;
            }
        }

        $attributes = implode(",\n        ", array_map(fn($f) => "'{$f['name']}' => null", $this->fields));

        $content = $this->renderer->render('entity.tpl', [
            'entity'     => $this->entity,
            'attributes' => $attributes,
        ]);

        write_file($target, $content);
        CLI::write("✅ " . lang('CrudGenerator.generated') . ": Entities/{$className}.php", 'green');
    }
}
