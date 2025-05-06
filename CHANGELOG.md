# 📝 CHANGELOG EN

## [v1.1.0] - 2025-05-06

### ✨ New Features

- **`.tpl` Template System**: Introduced a templating engine for views, controllers, models, and entities to improve customization and code maintainability.
- **Dynamic View Generation**: Views now use placeholders (`{{entityLower}}`, `{{theadFields}}`, etc.) that are dynamically replaced during code generation.
- **Enhanced Multilingual Support**: Added language files for both English and French, enabling seamless internationalization of generated interfaces.
- **Extended Spark Commands**:
  - `php spark make:crud`: Fully interactive CRUD generator.
  - `php spark crud:publish-lang`: Publishes language files into `app/Language`.
  - `php spark crud:publish-all`: Publishes all required files for manual setup.

### 🛠️ Improvements

- **Entity Name Validation**: Entity names must start with an uppercase letter and only contain alphanumeric characters or underscores.
- **Unparsed Placeholder Fixes**: Fixed issues where placeholders like `{{entity|lower}}` were left untouched in generated files.
- **Migration Management**: Improved detection and cleanup of obsolete or faulty migration files before running new ones.

### 🐛 Bug Fixes

- **SQL Errors in Migrations**: Fixed a SQL syntax error caused by improperly defined fields in migration files.
- **View Generation Issues**: Resolved a bug where some views failed to generate due to invalid field definitions or types.
- **Execution Message Display**: Fixed minor typos in console messages, especially during migration steps.

---

## [v1.0.4] - 2025-04-28

### 🛠️ Improvements

- **File Overwrite Confirmation**: Added interactive confirmation before overwriting existing files during generation.
- **`--force` Flag Support**: Enables forced file overwrites without confirmation using the `--force` option.

### 🐛 Bug Fixes

- **Route Generation Issues**: Fixed an issue where routes were not properly added to `Routes.php`.
- **Model Generation Errors**: Fixed a bug where generated models didn't follow the structure expected by CodeIgniter 4.

---

## [v1.0.3] - 2025-04-20

### ✨ New Features

- **Entity Support**: Automatically generates entity classes linked to models for cleaner data manipulation.

### 🛠️ Improvements

- **View Optimization**: Improved the structure of generated views for better readability and maintainability.

---

## [v1.0.2] - 2025-04-15

### 🛠️ Improvements

- **CodeIgniter 4.5 Compatibility**: Updated the generator to ensure full compatibility with CodeIgniter 4.5.

---

## [v1.0.1] - 2025-04-10

### 🐛 Bug Fixes

- **Controller Generation Issues**: Fixed a bug where generated controllers did not follow expected naming conventions.

---

## [v1.0.0] - 2025-04-05

### 🎉 Initial Stable Release

- **Full CRUD Generation**: Automatically creates models, entities, controllers, views, and migrations from a defined entity.
- **Interactive CLI Interface**: Uses Spark CLI for fully interactive component generation.
- **Multilingual Support**: Language files available for English and French.
- **Overwrite Protection**: Prompts for confirmation before overwriting existing files during generation.





# 📝 CHANGELOG FR

## [v1.1.0] - 2025-05-06

### ✨ Nouvelles fonctionnalités

- **Système de templates `.tpl`** : Introduction d’un moteur de templates pour les vues, contrôleurs, modèles et entités, facilitant la personnalisation et la maintenance du code généré.
- **Génération de vues dynamiques** : Les vues utilisent désormais des placeholders (`{{entityLower}}`, `{{theadFields}}`, etc.) remplacés dynamiquement lors de la génération.
- **Support multilingue amélioré** : Ajout de fichiers de langue pour l’anglais et le français, permettant une internationalisation aisée des interfaces générées.
- **Commandes Spark étendues** :
  - `php spark make:crud` : Génération interactive complète d’un CRUD.
  - `php spark crud:publish-lang` : Publication des fichiers de langue dans `app/Language`.
  - `php spark crud:publish-all` : Publication de tous les fichiers nécessaires pour une installation manuelle.

### 🛠️ Améliorations

- **Validation des noms d’entité** : Les noms doivent commencer par une majuscule et ne contenir que des lettres, chiffres ou underscores.
- **Correction des placeholders non interprétés** : Résolution des problèmes où des placeholders comme `{{entity|lower}}` apparaissaient tels quels dans les fichiers générés.
- **Gestion des migrations** : Amélioration de la détection et de la suppression des fichiers de migration obsolètes ou erronés avant l’exécution des nouvelles migrations.

### 🐛 Corrections de bugs

- **Erreur SQL lors des migrations** : Correction d’une erreur de syntaxe SQL causée par des champs mal définis dans les fichiers de migration.
- **Problèmes de génération de vues** : Résolution d’un bug où certaines vues n’étaient pas correctement générées en raison de champs mal définis ou de types invalides.
- **Affichage des messages d’exécution** : Correction de la typographie dans les messages affichés lors de l’exécution des commandes Spark, notamment pour les migrations.

---

## [v1.0.4] - 2025-04-28

### 🛠️ Améliorations

- **Confirmation avant écrasement de fichiers** : Ajout d’une confirmation interactive avant d’écraser des fichiers existants lors de la génération.
- **Support de la commande `--force`** : Possibilité de forcer l’écrasement des fichiers sans confirmation en utilisant l’option `--force`.

### 🐛 Corrections de bugs

- **Problèmes de génération de routes** : Correction d’un bug où les routes n’étaient pas correctement ajoutées au fichier `Routes.php`.
- **Erreurs lors de la génération des modèles** : Résolution d’un problème où les modèles générés ne respectaient pas la structure attendue par CodeIgniter 4.

---

## [v1.0.3] - 2025-04-20

### ✨ Nouvelles fonctionnalités

- **Support des entités** : Génération automatique des entités associées aux modèles pour une meilleure manipulation des données.

### 🛠️ Améliorations

- **Optimisation des vues** : Amélioration de la structure des vues générées pour une meilleure lisibilité et maintenabilité.

---

## [v1.0.2] - 2025-04-15

### 🛠️ Améliorations

- **Compatibilité avec CodeIgniter 4.5** : Mise à jour pour assurer la compatibilité avec la version 4.5 de CodeIgniter.

---

## [v1.0.1] - 2025-04-10

### 🐛 Corrections de bugs

- **Problèmes de génération de contrôleurs** : Correction d’un bug où les contrôleurs générés ne respectaient pas la convention de nommage attendue.

---

## [v1.0.0] - 2025-04-05

### 🎉 Première version stable

- **Génération complète de CRUD** : Création automatique des modèles, entités, contrôleurs, vues et fichiers de migration à partir d’une entité définie.
- **Interface CLI interactive** : Utilisation de la ligne de commande Spark pour une génération interactive des composants.
- **Support multilingue** : Fichiers de langue disponibles pour l’anglais et le français.
- **Protection contre l’écrasement** : Confirmation avant d’écraser des fichiers existants lors de la génération.