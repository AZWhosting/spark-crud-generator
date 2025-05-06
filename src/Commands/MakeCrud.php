<?php
// file: spark-crud-generator/src/Commands/MakeCrud.php
namespace SparkCrudGenerator\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\Services\TemplateRenderer;
use SparkCrudGenerator\Generators\ControllerGenerator;
use SparkCrudGenerator\Generators\ModelGenerator;
use SparkCrudGenerator\Generators\EntityGenerator;
use SparkCrudGenerator\Generators\MigrationGenerator;
use SparkCrudGenerator\Generators\ViewGenerator;
use SparkCrudGenerator\Generators\LayoutGenerator;
use SparkCrudGenerator\Generators\RouteManager;

/**
 * Class MakeCrud
 *
 * 🇬🇧 Main command to generate CRUD files using modular generators.
 * 🇫🇷 Commande principale pour générer un CRUD à l’aide de générateurs modulaires.
 */
class MakeCrud extends BaseCommand
{
    protected $group       = 'Generators';
    protected $name        = 'make:crud';
    protected $description = 'Generates a CRUD module (model, entity, controller, views, migration) using templates.';

    protected string $activeTemplate = 'default';
    protected bool $force = false;

    /**
     * Entry point for the Spark CLI command.
     *
     * 🇬🇧 Launches the interactive CRUD generator.
     * 🇫🇷 Lance l’interface interactive de génération CRUD.
     *
     * @param array $params CLI parameters
     * @return void
     */
public function run(array $params)
{
    // ⬇️ ⬅️ Test langue
    $lang = \Config\Services::language();
    $currentLocale = $lang->getLocale();
    CLI::write("🌍 Active locale: {$currentLocale}", 'yellow');

    $testKey = lang('CrudGenerator.askEntityName');
    if ($testKey === 'CrudGenerator.askEntityName') {
        CLI::error("❌ Language file not loaded or missing key: CrudGenerator.askEntityName");
    } else {
        CLI::write("✅ Language file loaded, sample value: {$testKey}", 'green');
    }

    $this->askTemplate();
    $entity = $this->askEntityName();
    $fields = $this->askFields();

    $this->force = CLI::getOption('force') ?? false;
    $renderer = new TemplateRenderer($this->activeTemplate);

    // Slugify the route base from entity (e.g., MyProduct => my-product)
    $routeBase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $entity));

    // Launch each modular generator
    (new ModelGenerator($entity, $fields, $renderer, $this->force))->generate();
    (new EntityGenerator($entity, $fields, $renderer, $this->force))->generate();
    (new ControllerGenerator($entity, $renderer, $this->force))->generate();
    (new MigrationGenerator($entity, $fields, $renderer, $this->force))->generate();
    (new ViewGenerator($entity, $fields, $renderer, $this->force))->generate();
    (new LayoutGenerator($renderer, $this->force))->generate();
    (new RouteManager($entity, $routeBase, $renderer))->handle();


    $this->askRunMigration();
}


    /**
     * Ask the user to select a template folder.
     *
     * 🇬🇧 Prompts user to choose which template (theme) to use.
     * 🇫🇷 Demande à l'utilisateur de choisir un dossier de templates.
     *
     * @return void
     */
    protected function askTemplate(): void
    {
        $basePath = __DIR__ . '/../../resources/templates/';
        /*$templates = array_filter(scandir($basePath), fn($d) =>
            $d !== '.' && $d !== '..' && is_dir($basePath . $d)
        );*/
        $templates = array_values(
            array_filter(scandir($basePath), function ($d) use ($basePath) {
                return $d !== '.' && $d !== '..' && is_dir($basePath . DIRECTORY_SEPARATOR . $d);
            })
        );

        if (empty($templates)) {
            throw new \RuntimeException(lang('CrudGenerator.templateDirNotFound', [$basePath]));
        }
        
        CLI::write("Templates found: " . implode(', ', $templates), 'yellow');

        $choice = CLI::prompt(lang('CrudGenerator.templateChoice') . ' [' . implode(', ', $templates) . ']', $templates);
        $this->activeTemplate = $choice;
        CLI::write(">> Using template: {$this->activeTemplate}", 'green');
    }

    /**
     * Ask and validate the entity name.
     *
     * 🇬🇧 Prompts user for an entity name and validates format and reserved words.
     * 🇫🇷 Demande le nom de l’entité et vérifie le format ainsi que les mots réservés PHP.
     *
     * @return string Validated entity name
     */
    protected function askEntityName(): string
    {
        helper('inflector');

        // Liste des mots réservés en PHP (vérifiés à la main)
        $reserved = [
            'class', 'function', 'trait', 'interface', 'extends', 'implements', 'static',
            'public', 'protected', 'private', 'const', 'var', 'if', 'else', 'while', 'for',
            'foreach', 'switch', 'case', 'default', 'break', 'continue', 'try', 'catch',
            'finally', 'throw', 'return', 'yield', 'new', 'clone', 'true', 'false', 'null',
            'and', 'or', 'xor', 'instanceof', 'global', 'namespace', 'use', 'require',
            'include', 'require_once', 'include_once', '__halt_compiler', 'goto', 'echo',
            'print', 'list', 'array', 'isset', 'unset', 'empty', 'eval', 'exit', 'die'
        ];

        while (true) {
            $entity = CLI::prompt(lang('CrudGenerator.askEntityName'));

            if (! preg_match('/^[A-Z][A-Za-z0-9_]*$/', $entity)) {
                CLI::error(lang('CrudGenerator.invalidEntityName'));
                continue;
            }

            if (in_array(strtolower($entity), $reserved)) {
                CLI::error(lang('CrudGenerator.reservedEntityName', [$entity]));
                continue;
            }

            return $entity;
        }
    }

    /**
     * Interactive loop to define entity fields.
     *
     * 🇬🇧 Asks the user to define each field (name, type, constraint, nullable, unique) with validation.
     * 🇫🇷 Demande les champs de l’entité avec validation (type, contrainte, nullable, unique).
     *
     * @return array List of fields
     */
    protected function askFields(): array
    {
        CLI::write(lang('CrudGenerator.fieldPrompt'), 'blue');

        $typesMap = [
            '1' => 'VARCHAR',
            '2' => 'TEXT',
            '3' => 'DECIMAL',
            '4' => 'INT',
            '5' => 'DATE',
            '6' => 'DATETIME',
        ];

        $reserved = [ // PHP reserved names
            'class', 'function', 'trait', 'interface', 'extends', 'implements', 'static',
            'public', 'protected', 'private', 'const', 'var', 'if', 'else', 'while', 'for',
            'foreach', 'switch', 'case', 'default', 'break', 'continue', 'try', 'catch',
            'finally', 'throw', 'return', 'yield', 'new', 'clone', 'true', 'false', 'null',
            'and', 'or', 'xor', 'instanceof', 'global', 'namespace', 'use', 'require',
            'include', 'require_once', 'include_once', '__halt_compiler', 'goto', 'echo',
            'print', 'list', 'array', 'isset', 'unset', 'empty', 'eval', 'exit', 'die'
        ];

        $fields = [];

        while (true) {
            $field = CLI::prompt(lang('CrudGenerator.askFieldName'));

            if (strtolower($field) === 'done' || strtolower($field) === 'q') {
                break;
            }

            if ($field === '') {
                CLI::error(lang('CrudGenerator.emptyFieldName'));
                continue;
            }

            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $field)) {
                CLI::error(lang('CrudGenerator.invalidFieldName'));
                continue;
            }

            if (in_array(strtolower($field), $reserved)) {
                CLI::error(lang('CrudGenerator.reservedFieldName', [$field]));
                continue;
            }

            // Affichage des types
            CLI::write(lang('CrudGenerator.typeList'), 'cyan');
            $typeInput = strtoupper(CLI::prompt(lang('CrudGenerator.askFieldType', [$field])));

            $type = $typesMap[$typeInput] ?? (in_array($typeInput, $typesMap) ? $typeInput : null);

            while (!$type) {
                CLI::error(lang('CrudGenerator.invalidType'));
                CLI::write(lang('CrudGenerator.typeList'), 'cyan');
                $typeInput = strtoupper(CLI::prompt(lang('CrudGenerator.askFieldType', [$field])));
                $type = $typesMap[$typeInput] ?? (in_array($typeInput, $typesMap) ? $typeInput : null);
            }

            // Contrainte uniquement pour VARCHAR, DECIMAL, INT
            $constraint = in_array($type, ['VARCHAR', 'DECIMAL', 'INT'])
                ? CLI::prompt(lang('CrudGenerator.askFieldConstraint', [$field]))
                : null;

            $nullable = CLI::prompt(lang('CrudGenerator.askNullable'), ['y', 'n']) === 'y';
            $unique   = CLI::prompt(lang('CrudGenerator.fieldUnique') . ' (y/n)', ['y', 'n']) === 'y';

            $fields[] = [
                'name'       => $field,
                'type'       => $type,
                'constraint' => $constraint,
                'nullable'   => $nullable,
                'unique'     => $unique,
            ];
        }

        return $fields;
    }


    /**
     * Ask whether to run migrations now.
     *
     * 🇬🇧 Propose to run php spark migrate after generation.
     * 🇫🇷 Propose d’exécuter la migration après génération.
     *
     * @return void
     */
    protected function askRunMigration(): void
    {
        if (CLI::prompt(lang('CrudGenerator.askRunMigration'), ['y', 'n']) === 'y') {
            CLI::write(lang('CrudGenerator.runningMigration'), 'cyan');
            command('migrate');
            CLI::write(lang('CrudGenerator.migrationDone'), 'green');
        }
    }
}
