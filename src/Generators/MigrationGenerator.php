<?php

namespace SparkCrudGenerator\Generators;

use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\Services\TemplateRenderer;

/**
 * Class MigrationGenerator
 *
 * 🇬🇧 Generates the migration file for the entity using a template.
 * 🇫🇷 Génère le fichier de migration de la table pour l’entité à partir d’un template.
 */
class MigrationGenerator
{
    protected string $entity;
    protected array $fields;
    protected TemplateRenderer $renderer;
    protected bool $force;

    /**
     * Constructor
     *
     * @param string           $entity
     * @param array            $fields
     * @param TemplateRenderer $renderer
     * @param bool             $force
     */
    public function __construct(string $entity, array $fields, TemplateRenderer $renderer, bool $force = false)
    {
        $this->entity   = $entity;
        $this->fields   = $fields;
        $this->renderer = $renderer;
        $this->force    = $force;
    }

    /**
     * Generate the migration file using migration.tpl
     *
     * 🇬🇧 Builds migration file based on field definitions and entity.
     * 🇫🇷 Construit le fichier de migration à partir des champs et de l'entité.
     *
     * @return void
     */
    public function generate(): void
    {
        $table     = strtolower(plural($this->entity));
        $timestamp = date('YmdHis');
        $filename  = "{$timestamp}_create_{$table}_table.php";
        $target    = APPPATH . "Database/Migrations/{$filename}";

        if (is_file($target) && ! $this->force) {
            $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', [$target]), ['y', 'n']) === 'y';
            if (! $overwrite) {
                CLI::write("❌ {$filename} " . lang('CrudGenerator.skippedExisting'), 'yellow');
                return;
            }
        }

        // Formatage des champs pour le template
        $lines = [];
        foreach ($this->fields as $field) {
            $type      = strtoupper($field['type']);
            $nullable  = $field['nullable'] ? 'true' : 'false';
            $unique    = $field['unique'] ? "'unique' => true, " : '';
            $constraint = '';

            // Ajouter une contrainte si applicable
            if (in_array($type, ['VARCHAR', 'DECIMAL', 'INT']) && !empty($field['constraint'])) {
                $constraint = "'constraint' => '{$field['constraint']}', ";
            }

            $lines[] = "            '{$field['name']}' => [ 'type' => '{$type}', {$constraint}{$unique}'null' => {$nullable} ],";
        }

        $fieldsCode = implode("\n", $lines);

        $content = $this->renderer->render('migration.tpl', [
            'entity' => $this->entity,
            'table'  => $table,
            'fields' => $fieldsCode,
        ]);

        write_file($target, $content);
        CLI::write("✅ " . lang('CrudGenerator.generated') . ": Database/Migrations/{$filename}", 'green');
    }

}
