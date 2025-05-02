<?php
// file: app/Language/fr/CrudGenerator.php
return [
    'commandDescription' => 'Génère un CRUD interactif : modèle, entité, migration, contrôleur, vues et templates',
    'askEntityName'      => "Nom de l'entité (ex:Produit)",
    'askFieldName'       => 'Nom du champ (ou "done") pour passer à la suite',
    'askFieldType'       => 'Type pour {0} (ex: VARCHAR, TEXT, DECIMAL, INT)',
    'askFieldConstraint' => 'Taille/contrainte pour {0} (ex: 100, 10,2)',
    'askNullable'        => 'Ce champ est-il nullable ? g(y/n)',
    'confirmOverwrite'   => 'Le fichier {0} existe déjà. Écraser ? (y/n)',
    'confirmAllExists'   => '❗ Des fichiers pour l\'entité "{0}" existent déjà. Continuer ? (y/n)',
    'abort'              => '⛔ Opération annulée.',
    'startFieldPrompt'   => 'Ajouter des champs un par un. Tapez "done" quand vous avez terminé.',
    'success'            => '✅ CRUD généré pour l\'entité : {0}',
    'tableExists'        => '⚠️ La table "{0}" existe déjà dans la base de données. Continuer ? (y/n)',
    'typeList'          => 
        "📌 Types de champs disponibles:\n" .
        "  [1] VARCHAR\n" .
        "  [2] TEXT\n" .
        "  [3] DECIMAL\n" .
        "  [4] INT\n" .
        "  [5] DATE\n" .
        "  [6] DATETIME\n" ,
    'invalidType' => "❌ Type invalide. Veuillez choisir un numéro ou un type valide depuis la liste.",
    'generationSummary' => '📦 Récapitulatif de la génération :',
    'model'            => 'Modèle',
    'skippedExisting'  => '❌ ignoré (déjà existant)',
    'tableExists'      => '⚠️ La table "{0}" existe déjà dans la base de données. Continuer ? (y/n)',
    'generated' => '✅ généré',
    'entity' => 'Entité',
    'migration'           => 'Migration',
    'migrationAborted'    => '⛔ Migration annulée.',
    'abortedTableExists'  => '❌ annulée (table existante)',
    'controller' => 'Contrôleur',
    'createNew' => 'Créer un nouveau',
    'edit'   => 'Modifier',
    'delete' => 'Supprimer',
    'viewIndex' => 'Vue : index',
    'skipped'   => '❌ ignorée',
    'viewCreate' => 'Vue : create',
    'save'       => 'Enregistrer',
    'viewEdit'     => 'Vue : edit',
    'viewShow'     => 'Vue : show',
    'update'       => 'Mettre à jour',
    'backToList'   => 'Retour à la liste',
    'appTitle' => 'Mon application',
    'templateHeader' => 'Template : header',
    'templateFooter' => 'Template : footer',
    'emptyFieldName' => '❌ Le nom du champ ne peut pas être vide.',
    'invalidFieldName' => '❌ Nom de champ invalide. Utilisez uniquement des lettres, chiffres ou underscores, sans espace. Doit commencer par une lettre ou un underscore.',
    'reservedEntityName' => '❌ "{0}" est un mot réservé de PHP. Choisis un autre nom d\'entité.',
    'routesReminder' => '📌 N\'oubliez pas d\'ajouter ces routes dans app/Config/Routes.php:',
    'visitLink' => 'Accéder à l\'interface CRUD générée',
    'askRunMigration'    => 'Souhaitez-vous executer la mise à jour dans la base de données ? (php spark migrate)',
    'runningMigration'   => '🔁 Exécution des migrations...',
    'migrationDone'      => '✅ Migration terminée !',
    'editItem' => 'Modifier %s',
];