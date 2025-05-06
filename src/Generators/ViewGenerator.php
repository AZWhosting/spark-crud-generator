<?php
// Path: spark-crud-generator/src/Generators/ViewGenerator.php
namespace SparkCrudGenerator\Generators;

use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\Services\TemplateRenderer;

/**
 * Class ViewGenerator
 *
 * 🇬🇧 Generates the CRUD view files for the entity using templates.
 * 🇫🇷 Génère les fichiers de vues CRUD pour l’entité à partir de templates.
 */
class ViewGenerator
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
     * Generate CRUD view files: index, create, edit, show
     *
     * 🇬🇧 Builds views with injected variables and header/footer handled in controller.
     * 🇫🇷 Construit les vues avec variables injectées ; header/footer gérés dans le contrôleur.
     *
     * @return void
     */
    public function generate(): void
    {
        $viewDir = APPPATH . 'Views/' . strtolower($this->entity) . '/';
        if (! is_dir($viewDir)) {
            mkdir($viewDir, 0777, true);
        }

        $views = ['index', 'create', 'edit', 'show'];

        foreach ($views as $view) {
            $targetFile = $viewDir . $view . '.php';

            if (is_file($targetFile) && ! $this->force) {
                $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', [$targetFile]), ['y', 'n']) === 'y';
                if (! $overwrite) {
                    CLI::write("❌ {$view}.php " . lang('CrudGenerator.skippedExisting'), 'yellow');
                    continue;
                }
            }

            $content = $this->renderer->render("views/{$view}.tpl", [
                'entity'      => $this->entity,
                'entityLower' => strtolower($this->entity),
                'viewPath'    => strtolower($this->entity),
                'title'       => lang("CrudGenerator.view" . ucfirst($view)),
                'formFields'  => $this->generateFormFields(),
                'showFields'  => $this->generateShowFields(),
                'theadFields' => $this->generateThead(),
                'tbodyFields' => $this->generateTbody(),
            ]);

            write_file($targetFile, $content);
            CLI::write("✅ " . lang('CrudGenerator.generated') . ": Views/{$this->entity}/{$view}.php", 'green');
        }
    }

    /**
     * Generate <li> fields for show view 
     */
    protected function generateFormFields(): string
    {
        return implode("\n", array_map(fn($f) =>
            "    <div style=\"margin-bottom: 1em;\">\n" .
            "        <label for=\"{$f['name']}\" style=\"display: block; margin-bottom: 0.5em;\">{$f['name']}</label>\n" .
            "        <input id=\"{$f['name']}\" name=\"{$f['name']}\" value=\"<?= old('{$f['name']}', \$item->{$f['name']} ?? '') ?>\">\n" .
            "    </div>",
            $this->fields
        ));
    }

    protected function generateShowFields(): string
    {
        return implode("\n", array_map(fn($f) =>
            "    <li><strong>{$f['name']}:</strong> <?= \$item->{$f['name']} ?></li>",
            $this->fields
        ));
    }

    /**
     * Generate <th> headers for table
     */
    protected function generateThead(): string
    {
        return implode("\n", array_map(fn($f) =>
            "        <th>{$f['name']}</th>",
            $this->fields
        ));
    }

    /**
     * Generate <td> cells for each item in table
     */
    protected function generateTbody(): string
    {
        return implode("\n", array_map(fn($f) =>
            "        <td><?= \$" . strtolower($this->entity) . "->{$f['name']} ?></td>",
            $this->fields
        ));
    }
}
