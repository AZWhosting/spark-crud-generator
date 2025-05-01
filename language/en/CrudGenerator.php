<?php

return [
    'commandDescription' => 'Generates an interactive CRUD: model, entity, migration, controller, views and templates',
    'askEntityName'      => "Entity name (e.g., Product)",
    'askFieldName'       => 'Field name (or "done") to proceed',
    'askFieldType'       => 'Type for {0} (e.g., VARCHAR, TEXT, DECIMAL, INT)',
    'askFieldConstraint' => 'Constraint for {0} (e.g., 100, 10,2)',
    'askNullable'        => 'Is this field nullable? (y/n)',
    'confirmOverwrite'   => 'The file "{0}" already exists. Overwrite? (y/n)',
    'confirmAllExists'   => '❗ CRUD files for the entity "{0}" already exist. Continue and overwrite if necessary? (y/n)',
    'abort'              => '⛔ Operation cancelled.',
    'startFieldPrompt'   => 'Add fields one by one. Type "done" when finished.',
    'success'            => '✅ CRUD generated for entity: {0}',
    'tableExists'        => '⚠️ The table "{0}" already exists in the database. Continue? (y/n)',
    'typeList'           => 
        "📌 Available field types:\n" .
        "  [1] VARCHAR\n" .
        "  [2] TEXT\n" .
        "  [3] DECIMAL\n" .
        "  [4] INT\n" .
        "  [5] DATE\n" .
        "  [6] DATETIME\n" ,
    'invalidType' => "❌ Invalid type. Please choose a number or a valid type from the list.",
    'generationSummary' => '📦 Generation summary:',
    'model'            => 'Model',
    'skippedExisting'  => '❌ skipped (already exists)',
    'tableExists'      => '⚠️ The table "{0}" already exists in the database. Continue? (y/n)',
    'generated'        => '✅ generated',
    'entity' => 'Entity',
    'migration'           => 'Migration',
    'migrationAborted'    => '⛔ Migration aborted.',
    'abortedTableExists'  => '❌ aborted (table already exists)',
    'controller' => 'Controller',
    'createNew' => 'Create new',
    'edit'   => 'Edit',
    'delete' => 'Delete',
    'viewIndex' => 'View: index',
    'skipped'   => '❌ skipped',
    'viewCreate' => 'View: create',
    'save'       => 'Save',
    'viewEdit'     => 'View: edit',
    'viewShow'     => 'View: show',
    'update'       => 'Update',
    'backToList'   => 'Back to list',
    'appTitle' => 'My Application',
    'templateHeader' => 'Template: header',
    'templateFooter' => 'Template: footer',
    'emptyFieldName' => '❌ Field name cannot be empty.',
    'invalidFieldName' => '❌ Invalid field name. Use only letters, numbers, or underscores. Must start with a letter or underscore.',
    'reservedEntityName' => '❌ "{0}" is a reserved PHP keyword. Please choose another entity name.',

]; 