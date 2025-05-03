<?php

namespace SparkCrudGenerator\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class PublishCrudLang extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'crud:publish-lang';
    protected $description = 'Publish only CRUD language files to app/Language';

    public function run(array $params)
    {
        $langPath = realpath(__DIR__ . '/../../../resources/language');

        foreach (['en', 'fr'] as $lang) {
            $source = "{$langPath}/{$lang}/CrudGenerator.php";
            $targetDir = APPPATH . "Language/{$lang}";
            $target = "{$targetDir}/CrudGenerator.php";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            if (copy($source, $target)) {
                CLI::write("✅ {$lang} language file published.", 'green');
            }
        }

        CLI::write('🌍 Language files published to app/Language', 'green');
    }
}

class PublishCrudAll extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'crud:publish-all';
    protected $description = 'Publish CRUD language files and MakeCrud command to app/';

    public function run(array $params)
    {
        // Fichiers de langue
        (new PublishCrudLang())->run($params);

        // MakeCrud
        $manualPath = realpath(__DIR__ . '/../../../resources/app');
        $source = "{$manualPath}/Commands/MakeCrud.php";
        $targetDir = APPPATH . "Commands";
        $target = "{$targetDir}/MakeCrud.php";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (copy($source, $target)) {
            CLI::write("✅ MakeCrud.php published to app/Commands", 'green');
        }

        CLI::write('🚀 All CRUD assets published.', 'green');
    }
}
