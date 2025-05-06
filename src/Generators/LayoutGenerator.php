<?php

namespace SparkCrudGenerator\Generators;

use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\Services\TemplateRenderer;

/**
 * Class LayoutGenerator
 *
 * 🇬🇧 Generates the shared layout views (header and footer) from templates.
 * 🇫🇷 Génère les vues de layout partagées (header et footer) à partir de templates.
 */
class LayoutGenerator
{
    protected TemplateRenderer $renderer;
    protected bool $force;

    /**
     * Constructor
     *
     * @param TemplateRenderer $renderer
     * @param bool             $force
     */
    public function __construct(TemplateRenderer $renderer, bool $force = false)
    {
        $this->renderer = $renderer;
        $this->force    = $force;
    }

    /**
     * Generate header.php and footer.php in Views/templates/
     *
     * 🇬🇧 Builds layout views from layout templates.
     * 🇫🇷 Construit les fichiers de layout à partir des templates.
     *
     * @return void
     */
    public function generate(): void
    {
        $targetDir = APPPATH . 'Views/templates/';
        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $files = ['header', 'footer'];

        foreach ($files as $file) {
            $target = $targetDir . $file . '.php';

            if (is_file($target) && ! $this->force) {
                $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', [$target]), ['y', 'n']) === 'y';
                if (! $overwrite) {
                    CLI::write("❌ {$file}.php " . lang('CrudGenerator.skippedExisting'), 'yellow');
                    continue;
                }
            }

            $content = $this->renderer->render("views/layout/{$file}.tpl", []);
            write_file($target, $content);
            CLI::write("✅ " . lang('CrudGenerator.generated') . ": Views/templates/{$file}.php", 'green');
        }
    }
}
