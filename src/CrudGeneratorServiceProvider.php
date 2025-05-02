<?php

namespace SparkCrudGenerator;

use CodeIgniter\Autoloader\Autoloader;
use CodeIgniter\Config\BaseService;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Publisher\Publisher;

class CrudGeneratorServiceProvider extends BaseService
{
    public static function publish(): void
    {
        $publisher = service('publisher');

        $publisher->addNamespace('CrudGenerator', realpath(__DIR__ . '/../resources'));

        // Publier les fichiers de langue
        $publisher->publish([
            'CrudGenerator/Language/en/CrudGenerator.php' => APPPATH . 'Language/en/CrudGenerator.php',
            'CrudGenerator/Language/fr/CrudGenerator.php' => APPPATH . 'Language/fr/CrudGenerator.php',
        ]);
    }
}
