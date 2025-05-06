<?php

namespace SparkCrudGenerator\Generators;

use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\Services\TemplateRenderer;

/**
 * Class ModelGenerator
 *
 * 🇬🇧 Generates the model file for the CRUD entity using a template.
 * 🇫🇷 Génère le fichier modèle pour l'entité CRUD à partir d’un template.
 */
class ModelGenerator
{
    /**
     * @var string Entity name (e.g. Product)
     */
    protected string $entity;

    /**
     * @var array Fields from askFields() (with name/type/nullable/unique)
     */
    protected array $fields;

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
     * @param string            $entity   Entity name
     * @param array             $fields   Fields definitions
     * @param TemplateRenderer  $renderer Template engine
     * @param bool              $force    Force overwrite
     */
    public function __construct(string $entity, array $fields, TemplateRenderer $renderer, bool $force = false)
    {
        $this->entity   = $entity;
        $this->fields   = $fields;
        $this->renderer = $renderer;
        $this->force    = $force;
    }

    /**
     * Generate the model file.
     *
     * 🇬🇧 Builds the model using model.tpl.
     * 🇫🇷 Construit le modèle via model.tpl.
     *
     * @return void
     */
    public function generate(): void
    {
        $className      = $this->entity . 'Model';
        $table          = strtolower(plural($this->entity));
        $target         = APPPATH . "Models/{$className}.php";

        if (is_file($target) && ! $this->force) {
            $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', [$target]), ['y', 'n']) === 'y';
            if (! $overwrite) {
                CLI::write("❌ {$className}.php " . lang('CrudGenerator.skippedExisting'), 'yellow');
                return;
            }
        }

        $allowedFields = implode(', ', array_map(fn($f) => "'{$f['name']}'", $this->fields));
        $rules         = implode(",\n        ", array_map(fn($f) => "'{$f['name']}' => 'required'", $this->fields));

        $content = $this->renderer->render('model.tpl', [
            'entity'        => $this->entity,
            'table'         => $table,
            'allowedFields' => $allowedFields,
            'rules'         => $rules,
        ]);

        write_file($target, $content);
        CLI::write("✅ " . lang('CrudGenerator.generated') . ": Models/{$className}.php", 'green');
    }
}
