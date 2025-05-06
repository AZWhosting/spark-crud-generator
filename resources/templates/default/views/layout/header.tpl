<!DOCTYPE html>
<html lang="<?= esc(service('language')->getLocale() ?: 'en') ?>">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? lang('CrudGenerator.appTitle')) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <h1><?= lang('CrudGenerator.appTitle') ?></h1>
    </header>
    <main>
