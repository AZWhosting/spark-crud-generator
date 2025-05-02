<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeCrud extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'make:crud';
    protected $description;


/**
 * Exécute la commande.
 * Demande à l'utilisateur de saisir le nom de l'entité et les champs.
 * Vérifie si les fichiers CRUD existent déjà et demande confirmation avant de poursuivre.
 * Génère les fichiers nécessaires pour le CRUD.
 *
 * @param array $params Paramètres de la commande
 * @return void
 */
/**
 * Exécute la commande.
 * Demande à l'utilisateur de saisir le nom de l'entité et les champs.
 * Vérifie si les fichiers CRUD existent déjà et demande confirmation avant de poursuivre.
 * Génère les fichiers nécessaires pour le CRUD.
 *
 * @param array $params Paramètres de la commande
 * @return void
 */
public function run(array $params)
{
    // Détecter le flag --force
    $force = in_array('--force', $params) || in_array('-f', $params);

    // Liste des types valides
    $typesMap = [
        '1' => 'VARCHAR',
        '2' => 'TEXT',
        '3' => 'DECIMAL',
        '4' => 'INT',
        '5' => 'DATE',
        '6' => 'DATETIME',
    ];

    // Liste des mots réservés PHP
    $reserved = [
        'class', 'interface', 'trait', 'function', 'const', 'abstract', 'namespace', 'final',
        'break', 'case', 'continue', 'default', 'do', 'else', 'elseif', 'enddeclare', 'endfor',
        'endforeach', 'endif', 'endswitch', 'endwhile', 'for', 'foreach', 'goto', 'if', 'else',
        'include', 'include_once', 'require', 'require_once', 'return', 'switch', 'while',
        'and', 'or', 'xor', 'as', 'catch', 'declare', 'global', 'instanceof', 'insteadof',
        'new', 'print', 'static', 'throw', 'try', 'use', 'var', 'unset', '__halt_compiler',
        'self', 'parent', 'true', 'false', 'null', 'void', 'iterable', 'object', 'string',
        'int', 'float', 'bool', 'array', 'callable'
    ];

    // Saisie et validation du nom de l'entité
    $entity = '';
    while (true) {
        $entity = trim(CLI::prompt(lang('CrudGenerator.askEntityName')));

        if ($entity === '') {
            CLI::write(lang('CrudGenerator.emptyEntityName'), 'red');
            continue;
        }

        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $entity)) {
            CLI::write(lang('CrudGenerator.invalidEntityName'), 'red');
            continue;
        }

        if (in_array(strtolower($entity), $reserved)) {
            CLI::write(lang('CrudGenerator.reservedEntityName', [$entity]), 'red');
            continue;
        }

        break;
    }

    $entity = ucfirst($entity);
    $table  = strtolower($entity) . 's';

    // Vérification des fichiers existants
    $alreadyExists = false;
    $checks = [
        APPPATH . "Models/{$entity}Model.php",
        APPPATH . "Entities/{$entity}.php",
        APPPATH . "Controllers/{$entity}Controller.php",
        APPPATH . "Views/" . strtolower($entity),
    ];

    foreach ($checks as $path) {
        if (file_exists($path)) {
            $alreadyExists = true;
            break;
        }
    }

    if ($alreadyExists && !$force) {
        $proceed = CLI::prompt(lang('CrudGenerator.confirmAllExists', [$entity]), ['y', 'n'], 'required');
        if ($proceed !== 'y') {
            CLI::write(lang('CrudGenerator.abort'), 'red');
            return;
        }
    }

    // Collecte des champs
    $fields = [];
    CLI::write(lang('CrudGenerator.startFieldPrompt'), 'yellow');

    while (true) {
        // Nom du champ
        $field = '';
        while (true) {
            $field = trim(CLI::prompt(lang('CrudGenerator.askFieldName')));
            if (strtolower($field) === 'done') break 2;

            if ($field === '') {
                CLI::write(lang('CrudGenerator.emptyFieldName'), 'red');
                continue;
            }

            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $field)) {
                CLI::write(lang('CrudGenerator.invalidFieldName'), 'red');
                continue;
            }

            if (in_array(strtolower($field), $reserved)) {
                CLI::write(lang('CrudGenerator.reservedFieldName', [$field]), 'red');
                continue;
            }

            break;
        }

        // Type du champ
        CLI::write(lang('CrudGenerator.typeList'), 'blue');

        $typeInput = strtoupper(CLI::prompt(lang('CrudGenerator.askFieldType', [$field]), null, 'required'));
        $type      = $typesMap[$typeInput] ?? (in_array($typeInput, $typesMap) ? $typeInput : null);

        while (!$type) {
            CLI::write(lang('CrudGenerator.invalidType'), 'red');
            CLI::write(lang('CrudGenerator.typeList'), 'blue');
            $typeInput = strtoupper(CLI::prompt(lang('CrudGenerator.askFieldType', [$field]), null, 'required'));
            $type      = $typesMap[$typeInput] ?? (in_array($typeInput, $typesMap) ? $typeInput : null);
        }

        // Contrainte si nécessaire
        $constraint = in_array($type, ['VARCHAR', 'DECIMAL', 'INT'])
            ? CLI::prompt(lang('CrudGenerator.askFieldConstraint', [$field]), null, 'required')
            : null;

        $nullable = CLI::prompt(lang('CrudGenerator.askNullable'), ['y', 'n']) === 'y';

        $fields[] = [
            'name'       => $field,
            'type'       => $type,
            'constraint' => $constraint,
            'null'       => $nullable
        ];
    }

    // Appel des générateurs
    $summary = [];
    $this->generateModel($entity, $table, $fields, $force, $summary);
    $this->generateEntity($entity, $force, $summary);
    $this->generateMigration($entity, $table, $fields, $force, $summary);
    $this->generateController($entity, $force, $summary);
    $this->generateViews($entity, $fields, $force, $summary);
    $this->generateTemplates($force, $summary);

    // Résumé
    CLI::write(PHP_EOL . lang('CrudGenerator.generationSummary'), 'green');
    foreach ($summary as $part => $result) {
        CLI::write(" - {$part} : {$result}");
    }

    // Demander si l'utilisateur veut exécuter la migration
    if (CLI::prompt(lang('CrudGenerator.askRunMigration'), ['y', 'n']) === 'y') {
        CLI::write(lang('CrudGenerator.runningMigration'), 'yellow');
        command('migrate');
        CLI::write(lang('CrudGenerator.migrationDone'), 'green');
    }

    // Ajout final : les routes à copier
    $lcEntity = strtolower($entity);
    CLI::write(PHP_EOL . lang('CrudGenerator.routesReminder'), 'blue');
    CLI::write('');
    CLI::write('$routes->group(\'' . $lcEntity . '\', static function($routes) {', 'white');
    CLI::write("    \$routes->get('/', '{$entity}Controller::index');", 'white');
    CLI::write("    \$routes->get('create', '{$entity}Controller::create');", 'white');
    CLI::write("    \$routes->post('store', '{$entity}Controller::store');", 'white');
    CLI::write("    \$routes->get('edit/(:num)', '{$entity}Controller::edit/\$1');", 'white');
    CLI::write("    \$routes->post('update/(:num)', '{$entity}Controller::update/\$1');", 'white');
    CLI::write("    \$routes->get('delete/(:num)', '{$entity}Controller::delete/\$1');", 'white');
    CLI::write('});', 'white');

    // Lien cliquable vers le CRUD généré
    $url = base_url() . '' . $lcEntity;
    CLI::write(PHP_EOL . '🔗 ' . lang('CrudGenerator.visitLink') . ': ' . $url, 'green');
}




/**
 * Génère le modèle pour l'entité spécifiée.
 *
 * Crée le fichier "NomEntitéModel.php" dans le répertoire "app/Models" s'il n'existe pas déjà,
 * ou demande confirmation pour écraser si le fichier existe.
 * Le modèle généré inclut les paramètres CI4 classiques et des méthodes CRUD de base :
 * - getAll(), getById(), insertData(), updateData(), deleteData()
 *
 * @param string  $entity  Nom de l'entité (ex: Produit)
 * @param string  $table   Nom de la table associée (ex: produits)
 * @param array   $fields  Liste des champs définis pour l'entité
 * @param bool    $force   Si vrai, écrase sans confirmation
 * @param array  &$summary Référence au tableau de résumé
 * @return void
 */
protected function generateModel($entity, $table, $fields, $force = false, array &$summary = [])
{
    $directory = APPPATH . 'Models/';
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $allowedFields = [];
    $rules         = [];
    foreach ($fields as $f) {
        $name = $f['name'];
        $allowedFields[] = "'$name'";
        $rules[]         = "'$name' => 'required'";
    }

    $allowedFieldsStr = implode(', ', $allowedFields);
    $rulesStr         = implode(",\n        ", $rules);

    $modelPath = $directory . "{$entity}Model.php";

    if (file_exists($modelPath) && !$force) {
        $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', ["{$entity}Model.php"]), ['y', 'n']);
        if ($overwrite !== 'y') {
            $summary[lang('CrudGenerator.model')] = lang('CrudGenerator.skippedExisting');
            return;
        }
    }

    $content = <<<PHP
<?php

namespace App\Models;

use CodeIgniter\Model;

class {$entity}Model extends Model
{
    protected \$table            = '{$table}';
    protected \$primaryKey       = 'id';
    protected \$useAutoIncrement = true;
    protected \$returnType       = '\\App\\Entities\\{$entity}';
    protected \$useSoftDeletes   = true;
    protected \$allowedFields    = [{$allowedFieldsStr}];
    protected \$useTimestamps    = true;
    protected \$createdField     = 'created_at';
    protected \$updatedField     = 'updated_at';
    protected \$deletedField     = 'deleted_at';

    protected \$validationRules = [
        {$rulesStr}
    ];

    public function getAll()
    {
        return \$this->findAll();
    }

    public function getById(\$id)
    {
        return \$this->find(\$id);
    }

    public function insertData(\$data)
    {
        return \$this->insert(\$data);
    }

    public function updateData(\$id, \$data)
    {
        return \$this->update(\$id, \$data);
    }

    public function deleteData(\$id)
    {
        return \$this->delete(\$id);
    }
}
PHP;

    file_put_contents($modelPath, $content);

    $summary[lang('CrudGenerator.model')] = lang('CrudGenerator.generated');

}




/**
 * Génère l'entité pour l'entité spécifiée.
 *
 * Crée le fichier "NomEntité.php" dans le répertoire "app/Entities" s'il n'existe pas déjà,
 * ou demande confirmation pour écraser si le fichier existe.
 * L'entité contient la configuration de base des dates gérées automatiquement par CI4.
 *
 * @param string  $entity  Nom de l'entité (ex: Produit)
 * @param bool    $force   Si vrai, écrase sans confirmation
 * @param array  &$summary Référence au tableau de résumé
 * @return void
 */
protected function generateEntity($entity, $force = false, array &$summary = [])
{
    $directory = APPPATH . 'Entities/';
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $path = $directory . "{$entity}.php";

    if (file_exists($path) && !$force) {
        $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', ["{$entity}.php"]), ['y', 'n']);
        if ($overwrite !== 'y') {
                $summary[lang('CrudGenerator.entity')] = lang('CrudGenerator.skippedExisting');
            return;
        }
    }

    $content = <<<PHP
<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class {$entity} extends Entity
{
    protected \$dates = ['created_at', 'updated_at', 'deleted_at'];
}
PHP;

    file_put_contents($path, $content);

    $summary[lang('CrudGenerator.entity')] = lang('CrudGenerator.skippedExisting');

}

/**
 * Génère une migration pour la table associée à l'entité.
 *
 * Crée un fichier de migration dans "app/Database/Migrations" nommé avec un timestamp
 * suivi de "CreateNomEntitéTable.php". Si un fichier avec le même nom existe déjà,
 * une confirmation est demandée avant de l'écraser sauf si --force est actif.
 * Vérifie également si la table existe déjà dans la base de données.
 *
 * @param string  $entity  Nom de l'entité (ex: Produit)
 * @param string  $table   Nom de la table (ex: produits)
 * @param array   $fields  Liste des champs de la table
 * @param bool    $force   Si vrai, écrase sans confirmation
 * @param array  &$summary Référence au tableau de résumé
 * @return void
 */
protected function generateMigration($entity, $table, $fields, $force = false, array &$summary = [])
{
    $directory = APPPATH . 'Database/Migrations/';
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $date     = date('Y-m-d-His');
    $filename = "{$date}_Create{$entity}Table.php";
    $path     = $directory . $filename;

    // Vérifie si la table existe déjà dans la base
    $db = \Config\Database::connect();
    if ($db->tableExists($table) && !$force) {
        $confirm = CLI::prompt(lang('CrudGenerator.tableExists', [$table]), ['y', 'n']);
        if ($confirm !== 'y') {
            CLI::write(lang('CrudGenerator.migrationAborted'), 'red');
            $summary[lang('CrudGenerator.migration')] = lang('CrudGenerator.abortedTableExists');
            return;
        }
    }

    if (file_exists($path) && !$force) {
        $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', [$filename]), ['y', 'n']);
        if ($overwrite !== 'y') {
            $summary[lang('CrudGenerator.migration')] = lang('CrudGenerator.skippedExisting');
            return;
        }
    }


    $fieldStr = '';
    foreach ($fields as $field) {
        $line = "'{$field['name']}' => ['type' => '{$field['type']}'";
        if (!empty($field['constraint'])) {
            $line .= ", 'constraint' => '{$field['constraint']}'";
        }
        if ($field['null']) {
            $line .= ", 'null' => true";
        }
        $line .= "],\n";
        $fieldStr .= $line;
    }

    $content = <<<PHP
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Create{$entity}Table extends Migration
{
    public function up()
    {
        \$this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            {$fieldStr}
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        \$this->forge->addKey('id', true);
        \$this->forge->createTable('{$table}');
    }

    public function down()
    {
        \$this->forge->dropTable('{$table}');
    }
}
PHP;

    file_put_contents($path, $content);

    $summary[lang('CrudGenerator.migration')] = lang('CrudGenerator.generated');

}

protected function generateController($entity, $force = false, array &$summary = [])
{
    $directory = APPPATH . 'Controllers/';
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $controllerPath = $directory . "{$entity}Controller.php";

    if (file_exists($controllerPath) && !$force) {
        $overwrite = CLI::prompt(lang('CrudGenerator.confirmOverwrite', ["{$entity}Controller.php"]), ['y', 'n']);
        if ($overwrite !== 'y') {
            $summary[lang('CrudGenerator.controller')] = lang('CrudGenerator.skippedExisting');

            return;
        }
    }

    $var = strtolower($entity);

    $content = <<<PHP
<?php

namespace App\Controllers;

use App\Models\\{$entity}Model;
use CodeIgniter\\Controller;

class {$entity}Controller extends Controller
{
    protected \$model;

    public function __construct()
    {
        \$this->model = new {$entity}Model();
    }

    public function index()
    {
        \$data['{$var}s'] = \$this->model->findAll();
        return view('{$var}/index', \$data);
    }

    public function create()
    {
        return view('{$var}/create');
    }

    public function store()
    {
        \$this->model->save(\$this->request->getPost());
        return redirect()->to('/{$var}');
    }

    public function edit(\$id)
    {
        \$data['{$var}'] = \$this->model->find(\$id);
        return view('{$var}/edit', \$data);
    }

    public function update(\$id)
    {
        \$this->model->update(\$id, \$this->request->getPost());
        return redirect()->to('/{$var}');
    }

    public function delete(\$id)
    {
        \$this->model->delete(\$id);
        return redirect()->to('/{$var}');
    }
}
PHP;

    file_put_contents($controllerPath, $content);
    $summary[lang('CrudGenerator.controller')] = lang('CrudGenerator.generated');

}



/**
 * Génère les vues de base pour une entité donnée.
 *
 * Cette méthode crée un répertoire dans app/Views/ portant le nom de l'entité (en minuscule),
 * puis génère les fichiers suivants si l'utilisateur le confirme ou s'ils n'existent pas :
 * - index.php : liste des éléments
 * - create.php : formulaire de création
 * - edit.php : formulaire d'édition
 * - show.php : affichage détaillé d'un élément
 *
 * Chaque vue inclut les fichiers de template header.php et footer.php.
 *
 * @param string  $entity   Nom de l'entité
 * @param array   $fields   Liste des champs définis pour l'entité
 * @param bool    $force    Si vrai, écrase sans confirmation
 * @param array  &$summary  Référence au tableau de résumé
 * @return void
 */
protected function generateViews($entity, $fields, $force = false, array &$summary = [])
{
    $var       = strtolower($entity);
    $directory = APPPATH . "Views/{$var}/";
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    // index.php
    $indexPath = $directory . 'index.php';
    if (!file_exists($indexPath) || $force || CLI::prompt(lang('CrudGenerator.confirmOverwrite', ['index.php']), ['y', 'n']) === 'y') {
        $index = <<<HTML
<?= \$this->include('templates/header') ?>

<h1>Liste des {$var}s</h1>
<a href="/{$var}/create"><?= lang('CrudGenerator.createNew') ?></a>
<table border="1">
    <tr>
HTML;
        foreach ($fields as $f) {
            $index .= "        <th>{$f['name']}</th>\n";
        }
        $index .= <<<HTML
        <th>Actions</th>
    </tr>
    <?php foreach (\${$var}s as \${$var}): ?>
    <tr>
HTML;
        foreach ($fields as $f) {
            $index .= "        <td><?= \${$var}->{$f['name']} ?></td>\n";
        }
        $index .= <<<HTML
        <td>
            <a href="/{$var}/edit/<?= \${$var}->id ?>"><?= lang('CrudGenerator.edit') ?></a>
            <a href="/{$var}/delete/<?= \${$var}->id ?>"><?= lang('CrudGenerator.delete') ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?= \$this->include('templates/footer') ?>
HTML;

        file_put_contents($indexPath, $index);
        $summary[lang('CrudGenerator.viewIndex')] = lang('CrudGenerator.generated');
    } else {
        $summary[lang('CrudGenerator.viewIndex')] = lang('CrudGenerator.skipped');
    }

    // create.php
    $createPath = $directory . 'create.php';
    if (!file_exists($createPath) || $force || CLI::prompt(lang('CrudGenerator.confirmOverwrite', ['create.php']), ['y', 'n']) === 'y') {
        $create = <<<HTML
<?= \$this->include('templates/header') ?>

<h1>Créer un nouveau {$var}</h1>
<form action="/{$var}/store" method="post">
HTML;
        foreach ($fields as $f) {
            $create .= <<<HTML

    <label for="{$f['name']}">{$f['name']}</label>
    <input type="text" name="{$f['name']}" id="{$f['name']}" />
HTML;
        }
        $create .= <<<HTML

    <button type="submit"><?= lang('CrudGenerator.save') ?></button>
</form>

<?= \$this->include('templates/footer') ?>
HTML;
        file_put_contents($createPath, $create);
        $summary[lang('CrudGenerator.viewCreate')] = lang('CrudGenerator.generated');
;
    } else {
        $summary[lang('CrudGenerator.viewCreate')] = lang('CrudGenerator.skipped');

    }

// edit.php
$editPath = $directory . 'edit.php';
if (!file_exists($editPath) || $force || CLI::prompt(lang('CrudGenerator.confirmOverwrite', ['edit.php']), ['y', 'n']) === 'y') {
    $edit = <<<HTML
<?= \$this->include('templates/header') ?>

<h1><?= sprintf(lang('CrudGenerator.editItem'), ucfirst('$var')) ?></h1>
<form action="/{$var}/update/<?= \${$var}->id ?>" method="post">
HTML;

    foreach ($fields as $f) {
        $edit .= <<<HTML

    <label for="{$f['name']}">{$f['name']}</label>
    <input type="text" name="{$f['name']}" id="{$f['name']}" value="<?= \${$var}->{$f['name']} ?>" />
HTML;
    }

    $edit .= <<<HTML

    <button type="submit"><?= lang('CrudGenerator.update') ?></button>
</form>

<?= \$this->include('templates/footer') ?>
HTML;

    file_put_contents($editPath, $edit);
    $summary[lang('CrudGenerator.viewEdit')] = lang('CrudGenerator.generated');
} else {
    $summary[lang('CrudGenerator.viewEdit')] = lang('CrudGenerator.skipped');
}



    // show.php
    $showPath = $directory . 'show.php';
    if (!file_exists($showPath) || $force || CLI::prompt(lang('CrudGenerator.confirmOverwrite', ['show.php']), ['y', 'n']) === 'y') {
        $show = <<<HTML
<?= \$this->include('templates/header') ?>

<h1>Détails {$var}</h1>
HTML;
        foreach ($fields as $f) {
            $show .= <<<HTML

<p><strong>{$f['name']}:</strong> <?= \${$var}->{$f['name']} ?></p>

HTML;
        }
        $show .= <<<HTML

<a href="/{$var}"><?= lang('CrudGenerator.backToList') ?></a>

<?= \$this->include('templates/footer') ?>
HTML;
        file_put_contents($showPath, $show);
        $summary[lang('CrudGenerator.viewShow')] = lang('CrudGenerator.generated');

    } else {
        $summary[lang('CrudGenerator.viewShow')] = lang('CrudGenerator.skipped');
    }
}



/**
 * Génère les templates de base pour les vues.
 *
 * Crée un dossier "templates" dans le répertoire "Views" s'il n'existe pas déjà.
 * Génère les fichiers "header.php" et "footer.php" uniquement s'ils n'existent pas,
 * ou après confirmation explicite de l'utilisateur en cas de conflit (sauf si --force).
 * Ces fichiers seront inclus dans toutes les vues générées.
 *
 * @param bool   $force    Si vrai, écrase sans confirmation
 * @param array &$summary  Référence au tableau de résumé
 * @return void
 */
protected function generateTemplates($force = false, array &$summary = [])
{
    $directory = APPPATH . 'Views/templates/';
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $headerPath = $directory . 'header.php';
    if (!file_exists($headerPath) || $force || CLI::prompt(lang('CrudGenerator.confirmOverwrite', ['header.php']), ['y', 'n']) === 'y') {
        $header = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= lang('CrudGenerator.appTitle') ?></title>

</head>
<body>
HTML;
        file_put_contents($headerPath, $header);
        $summary[lang('CrudGenerator.templateHeader')] = lang('CrudGenerator.generated');
    } else {
        $summary[lang('CrudGenerator.templateHeader')] = lang('CrudGenerator.skipped');
    }



    $footerPath = $directory . 'footer.php';
    if (!file_exists($footerPath) || $force || CLI::prompt(lang('CrudGenerator.confirmOverwrite', ['footer.php']), ['y', 'n']) === 'y') {
        $footer = <<<HTML
</body>
</html>
HTML;
        file_put_contents($footerPath, $footer);
        $summary[lang('CrudGenerator.templateFooter')] = lang('CrudGenerator.generated');
    } else {
        $summary[lang('CrudGenerator.templateFooter')] = lang('CrudGenerator.skipped');
    }
}

} // End of file MakeCrud.php
