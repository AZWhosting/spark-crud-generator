<?php
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeCrud extends BaseCommand
{
    protected $group       = 'Generators';
    protected $name        = 'make:crud';
    protected $description = 'Interactive CRUD generator for CodeIgniter 4';
    protected $usage       = 'make:crud';
    protected $arguments   = [];
    protected $options     = [
        '--force' => 'Force file overwrite without confirmation',
    ];

    public function run(array $params)
    {
        CLI::write('⚙️  Starting interactive CRUD generation...', 'green');

        // Étape 1 : Demander et valider le nom de l'entité
        $entityName = $this->askEntityName();
        $fields = $this->askFields();
        $this->generateMigration($entityName, $fields);
        $this->generateModel($entityName, $fields);
        $this->generateController($entityName);
        $this->generateEntity($entityName);




        CLI::write("✅ Entity name set to: {$entityName}", 'green');

        // Étapes suivantes à venir...
    }

    /**
     * 🔹 Étape 1 : Saisie et validation du nom d'entité
     */
    private function askEntityName(): string
    {
        while (true) {
            $name = CLI::prompt('📝 Enter the name of the entity (e.g. Product)', null, 'required');

            // Validation stricte
            if (! preg_match('/^[A-Z][A-Za-z0-9_]{2,}$/', $name)) {
                CLI::error('❌ Invalid name. Use PascalCase, start with a letter, min 3 chars.');
                continue;
            }

            if (in_array(strtolower($name), $this->getPhpReservedKeywords(), true)) {
                CLI::error("❌ '{$name}' is a reserved PHP keyword.");
                continue;
            }

            return $name;
        }
    }

    private function getPhpReservedKeywords(): array
    {
        return [
            '__halt_compiler', 'abstract', 'and', 'array', 'as', 'break', 'callable', 'case',
            'catch', 'class', 'clone', 'const', 'continue', 'declare', 'default', 'die', 'do',
            'echo', 'else', 'elseif', 'empty', 'enddeclare', 'endfor', 'endforeach', 'endif',
            'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'final', 'finally', 'for',
            'foreach', 'function', 'global', 'goto', 'if', 'implements', 'include', 'include_once',
            'instanceof', 'insteadof', 'interface', 'isset', 'list', 'match', 'namespace', 'new',
            'or', 'print', 'private', 'protected', 'public', 'readonly', 'require', 'require_once',
            'return', 'static', 'switch', 'throw', 'trait', 'try', 'unset', 'use', 'var', 'while', 'xor',
        ];
    }


    private function askFields(): array
    {
        $fields = [];

        CLI::write("➕ Let's define the fields for this entity", 'cyan');

        while (true) {
            $name = CLI::prompt('Field name (leave empty to finish)');
            if (empty($name)) {
                break;
            }

            if (! preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $name)) {
                CLI::error("❌ Invalid field name: {$name}");
                continue;
            }

            $type = CLI::prompt('Field type (string, text, integer, float, boolean, date, datetime)', 'string');

            $nullable = CLI::prompt('Nullable? (yes/no)', 'no') === 'yes';
            $unique   = CLI::prompt('Unique? (yes/no)', 'no') === 'yes';

            $fields[] = [
                'name'     => $name,
                'type'     => $type,
                'nullable' => $nullable,
                'unique'   => $unique,
            ];
        }

        CLI::write('✅ Fields collected: ' . count($fields), 'green');

        return $fields;
    }
    
    private function generateMigration(string $entityName, array $fields): void
    {
        $timestamp = date('YmdHis');
        $tableName = strtolower($entityName);
        $className = "Create{$entityName}Table";
        $filename  = "{$timestamp}_create_{$tableName}_table.php";
        $path      = APPPATH . "Database/Migrations/{$filename}";

        $content = "<?php\n\n";
        $content .= "namespace App\Database\Migrations;\n\n";
        $content .= "use CodeIgniter\Database\Migration;\n\n";
        $content .= "class {$className} extends Migration\n{\n";
        $content .= "    public function up()\n    {\n";
        $content .= "        \$this->forge->addField([\n";
        $content .= "            'id' => [\n";
        $content .= "                'type'           => 'INT',\n";
        $content .= "                'constraint'     => 11,\n";
        $content .= "                'unsigned'       => true,\n";
        $content .= "                'auto_increment' => true,\n";
        $content .= "            ],\n";

        foreach ($fields as $field) {
            $content .= "            '{$field['name']}' => [\n";
            $content .= "                'type' => '" . strtoupper($field['type']) . "',\n";

            if ($field['nullable']) {
                $content .= "                'null' => true,\n";
            }

            if ($field['unique']) {
                $content .= "                'unique' => true,\n";
            }

            $content .= "            ],\n";
        }

        $content .= "            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',\n";
        $content .= "            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',\n";
        $content .= "        ]);\n";
        $content .= "        \$this->forge->addKey('id', true);\n";
        $content .= "        \$this->forge->createTable('{$tableName}');\n";
        $content .= "    }\n\n";
        $content .= "    public function down()\n    {\n";
        $content .= "        \$this->forge->dropTable('{$tableName}');\n";
        $content .= "    }\n";
        $content .= "}\n";

        file_put_contents($path, $content);

        CLI::write("✅ Migration created: {$filename}", 'green');
    }

    /**
     * Génère un fichier Model pour l'entité donnée.
     *
     * @param string $entityName Nom de l'entité (ex. Product)
     * @param array  $fields     Liste des champs définis par l'utilisateur
     *
     * @return void
     */
    private function generateModel(string $entityName, array $fields): void
    {
        $className = $entityName . 'Model';
        $filePath  = APPPATH . "Models/{$className}.php";
        $table     = strtolower($entityName);
        $entity    = "App\\Entities\\{$entityName}";

        $fieldNames    = array_map(fn($f) => "'{$f['name']}'", $fields);
        $allowedFields = implode(', ', $fieldNames);

        $content = "<?php\n\n";
        $content .= "namespace App\Models;\n\n";
        $content .= "use CodeIgniter\Model;\n\n";
        $content .= "class {$className} extends Model\n";
        $content .= "{\n";
        $content .= "    protected \$table      = '{$table}';\n";
        $content .= "    protected \$primaryKey = 'id';\n\n";
        $content .= "    protected \$returnType    = '{$entity}';\n";
        $content .= "    protected \$useSoftDeletes = false;\n\n";
        $content .= "    protected \$allowedFields = [{$allowedFields}];\n\n";
        $content .= "    protected \$useTimestamps = true;\n";
        $content .= "    protected \$createdField  = 'created_at';\n";
        $content .= "    protected \$updatedField  = 'updated_at';\n";
        $content .= "}\n";

        file_put_contents($filePath, $content);

        CLI::write("✅ Model created: {$className}.php", 'green');
    }

     /**
     * Generate an Entity class file for the given entity name.
     * Génère une classe d'entité pour le nom d'entité donné.
     *
     * @param string $entityName Name of the entity / Nom de l'entité (e.g. Product)
     *
     * @return void
     */
    private function generateEntity(string $entityName): void
    {
        $className = $entityName;
        $filePath  = APPPATH . "Entities/{$className}.php";

        $content = "<?php\n\n";
        $content .= "namespace App\Entities;\n\n";
        $content .= "use CodeIgniter\Entity\Entity;\n\n";
        $content .= "class {$className} extends Entity\n";
        $content .= "{\n";
        $content .= "    // You can add accessors, mutators, and virtual attributes here\n";
        $content .= "    // Vous pouvez ajouter des accesseurs, mutateurs, ou attributs virtuels ici\n";
        $content .= "}\n";

        file_put_contents($filePath, $content);

        CLI::write("✅ Entity created: {$className}.php", 'green');
    }




} // End of file MakeCrud.php
