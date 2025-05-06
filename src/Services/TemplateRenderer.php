<?php
namespace SparkCrudGenerator\Services;
use RuntimeException;


/**
 * Class TemplateRenderer
 * Service to load and render .tpl files with variable injection.
 * 🇬🇧 Service to load and render .tpl files with variable injection.
 * 🇫🇷 Service pour charger et rendre les fichiers .tpl avec injection de variables.
 * 
 * path: spark-crud-generator/src/Services/TemplateRenderer.php
 * @package SparkCrudGenerator\Services
 */
class TemplateRenderer
{
    /**
     * Name of the active template folder (e.g., "default").
     *
     * @var string
     */
    protected string $template;

    /**
     * Constructor
     *
     * @param string $template Folder name of the template to use
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * Load a template file and replace variables.
     *
     * 🇬🇧 Loads a .tpl file and replaces {{var}} placeholders.
     * 🇫🇷 Charge un fichier .tpl et remplace les balises {{var}}.
     *
     * @param string $relativePath Path relative to the template folder (e.g. "model.tpl")
     * @param array  $vars         Key/value pairs to inject into the template
     *
     * @return string Rendered content
     * @throws RuntimeException if template file not found
     */
    public function render(string $relativePath, array $vars): string
    {
        $file = __DIR__ . '/../../resources/templates/' . $this->template . '/' . $relativePath;

        if (! is_file($file)) {
            throw new RuntimeException(lang('CrudGenerator.templateNotFound', [$file]));
        }

        $content = file_get_contents($file);

        foreach ($vars as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }

        return $content;
    }
}
