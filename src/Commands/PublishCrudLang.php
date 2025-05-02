<?php

namespace SparkCrudGenerator\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class PublishCrudLang extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'crud:publish-lang';
    protected $description = 'Publish CRUD language files - Publier les fichiers de langue CRUD';

    public function run(array $params)
    {
        $basePath = realpath(__DIR__ . '/../../../resources/language');

        $languages = ['en', 'fr'];
        foreach ($languages as $lang) {
            $source = "{$basePath}/{$lang}/CrudGenerator.php";
            $targetDir = APPPATH . "Language/{$lang}";
            $target = "{$targetDir}/CrudGenerator.php";

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            copy($source, $target);
        }

        CLI::write('✅ CRUD language files published to app/Language - Fichiers langue CRUD publiés dans app/Language', 'green');
    }
}

