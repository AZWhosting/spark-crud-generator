<?php

namespace SparkCrudGenerator\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use SparkCrudGenerator\CrudGeneratorServiceProvider;

class PublishCrudLang extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'crud:publish-lang';
    protected $description = 'Publish CRUD language files - Publier les fichiers de langue CRUD';

    public function run(array $params)
    {
        CrudGeneratorServiceProvider::publish();
        CLI::write('✅ CRUD language files published to app/Language - Fichiers langue CRUD publiés dans app/Language', 'green');
    }
}
