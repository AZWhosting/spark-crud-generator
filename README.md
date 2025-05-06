# 🚀 Spark CRUD Generator for CodeIgniter 4

![Version](https://img.shields.io/github/v/tag/AZWhosting/spark-crud-generator?label=version&sort=semver)
![License](https://img.shields.io/github/license/AZWhosting/spark-crud-generator)
![PHP](https://img.shields.io/badge/php-%3E=7.4-blue)
![CI4 Compatible](https://img.shields.io/badge/CodeIgniter-4.x-red)


Choose your language / Choisissez votre langue :
- [🇬🇧 English](#-english-version)
- [🇫🇷 Français](#-version-française)

---

## 🇬🇧 English version

### 📚 Table of Contents

- [✨ Features](#-features)
- [⚙️ Installation](#installation)
- [🚀 Usage](#-usage)
- [📄 Options](#-options)
- [🌍 Localization](#-localization)
- [📁 Generated Structure](#-generated-structure)
- [🛡️ Safeguards](#safeguards)
- [📝 License](#-license)

---

### ✨ Features

- Generates **Model, Entity, Controller, Views, Migration**
- Interactive prompts for field definitions
- Language support (English & French)
- No file overwrite without confirmation
- `--force` mode to skip confirmations
- Clean structure: templates and CRUD folders
- Auto migration execution prompt
- Routes summary automatically displayed after generation
- Direct clickable link to CRUD interface
- Full entity support with `Entity` as object (no array access)
- Supports template themes (e.g., default, bootstrap, etc.)
- Modular architecture with dedicated classes per generator (model, controller, views, etc.)
- All code is rendered from .tpl files for full customization
- Header and footer layout support via layout templates
- Detects missing routes and optionally injects them into Routes.php
---

### ⚙️ Installation

#### Using Composer (recommended)

```bash
composer require azwhosting/spark-crud-generator --dev
```

Then publish the language files:

```bash
php spark crud:publish-lang
```

### ⚙️ Manual Installation

You can install the generator manually if you don't use Composer.

**Manual installation steps:**

1. Place the following files in your project:

```
app/Commands/MakeCrud.php
app/Language/en/CrudGenerator.php
app/Language/fr/CrudGenerator.php
```

> 📌 Create the folders if they don’t exist.

2. Run the generator from the Spark CLI:

```bash
php spark make:crud
```

3. Follow the interactive prompts to generate your CRUD.

You can now call it via Spark CLI.

---

### 🚀 Usage

```bash
php spark make:crud
```

Follow the prompts:
- Entity name
- Add fields one by one
- File creation with overwrite protection

Example:

```bash
php spark make:crud Product
```
---

### 🧩 Custom Templates

You can define your own generation theme by duplicating the default templates:

1. Copy the folder `resources/templates/default/` into a new folder `resources/templates/your-theme/`
2. Customize any `.tpl` file (controller, model, views, etc.)
3. Run `php spark make:crud` and select your theme when prompted

Templates use placeholders like `{{entity}}`, `{{fields}}`, `{{formFields}}`, etc.

---

### 🔄 Automatic Route Injection

After generation, the system offers to automatically inject routes into `app/Config/Routes.php`.

- If routes already exist, they will be skipped.
- If missing, the lines from `route.tpl` will be inserted after confirmation.
- A backup of `Routes.php` is automatically created before any modification.
- Manual fallback is always shown in case of conflict or refusal.

You can customize the injected routes by editing the `route.tpl` file inside your selected template.

---

### 📄 Options

| Option       | Description                           |
|--------------|---------------------------------------|
| `--force` or `-f` | Force overwrite without any confirmation |

---

### 🌍 Localization

Language files are located in:

```
app/Language/en/CrudGenerator.php
app/Language/fr/CrudGenerator.php
```

You can edit them or create your own translations.

---

### 📁 Generated Structure

```
app/
├── Controllers/
│   └── ProductController.php
├── Entities/
│   └── Product.php
├── Models/
│   └── ProductModel.php
├── Views/
│   ├── product/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── show.php
│   └── templates/
│       ├── header.php
│       └── footer.php
├── Database/
│   └── Migrations/
│       └── 2025-01-01-CreateProductTable.php
```

---

### 🛡️ Safeguards

- Checks if CRUD already exists
- Warns if a table already exists in DB
- Asks before overwriting any file
- Bypass everything with `--force`

---

### 📝 License

MIT License — Free to use, modify, share.

---

## 🇫🇷 Version française

### 📚 Sommaire

- [✨ Fonctionnalités](#-fonctionnalités)
- [⚙️ Installation](#installation-1)
- [🚀 Utilisation](#-utilisation)
- [📄 Options](#-options-1)
- [🌍 Localisation](#-localisation)
- [📁 Structure générée](#-structure-générée)
- [🛡️ Sécurités](#sécurités)
- [📝 Licence](#-licence)

---

### ✨ Fonctionnalités

- Génère **Modèle, Entité, Contrôleur, Vues, Migration**
- Interface interactive pour les champs
- Prise en charge de plusieurs langues (FR / EN)
- Aucun fichier écrasé sans confirmation
- Mode `--force` pour tout passer en force
- Structure claire : templates et vues par entité
- Suggestion d'exécution automatique de la migration
- Récapitulatif complet des routes à ajouter
- Lien cliquable direct vers l'interface CRUD générée
- Support complet des entités sous forme d'objets (plus d'accès tableau)
- Prise en charge des thèmes de templates (ex. : `default`, `bootstrap`, etc.)
- Architecture modulaire avec une classe dédiée par générateur (modèle, contrôleur, vues, etc.)
- Tout le code est généré à partir de fichiers `.tpl` entièrement personnalisables
- Gestion des layouts `header` et `footer` via des templates dédiés
- Détection des routes manquantes et injection automatique optionnelle dans `Routes.php`

---

### ⚙️ Installation

#### Via Composer (recommandé)

```bash
composer require azwhosting/spark-crud-generator --dev
```

Puis publiez les fichiers de langue :

```bash
php spark crud:publish-lang
```

### ⚙️ Installation manuelle

Vous pouvez installer le générateur manuellement si vous n'utilisez pas Composer.

**Étapes pour une installation manuelle :**

1. Placez les fichiers suivants dans votre projet :

```
app/Commands/MakeCrud.php
app/Language/en/CrudGenerator.php
app/Language/fr/CrudGenerator.php
```

> 📌 Créez les dossiers s'ils n'existent pas.

2. Lancez le générateur depuis le terminal Spark :

```bash
php spark make:crud
```

3. Suivez les instructions interactives pour générer le CRUD.

---

### 🧩 Templates personnalisés

Vous pouvez définir votre propre thème de génération en dupliquant les templates par défaut :

1. Copiez le dossier `resources/templates/default/` vers un nouveau dossier `resources/templates/votre-theme/`
2. Personnalisez les fichiers `.tpl` (contrôleur, modèle, vues, etc.)
3. Lancez la commande `php spark make:crud` et sélectionnez votre thème lorsqu’il est proposé

Les templates utilisent des balises comme `{{entity}}`, `{{fields}}`, `{{formFields}}`, etc.

---

## 🔄 Injection automatique des routes

À la fin de la génération, le système vous propose d’ajouter automatiquement les routes dans `app/Config/Routes.php`.

- Si les routes existent déjà, elles seront ignorées.
- Si elles sont absentes, les lignes de `route.tpl` seront insérées après confirmation.
- Une sauvegarde du fichier `Routes.php` est automatiquement créée avant toute modification.
- Un rappel manuel est toujours affiché en cas de refus ou de conflit.

Vous pouvez personnaliser les routes injectées en modifiant le fichier `route.tpl` du thème utilisé

---

### 🚀 Utilisation

```bash
php spark make:crud
```

Répondez aux questions :
- Nom de l'entité
- Ajout des champs un à un
- Création des fichiers avec protections

Exemple :

```bash
php spark make:crud Produit
```

---

### 📄 Options

| Option       | Description                                       |
|--------------|---------------------------------------------------|
| `--force` ou `-f` | Forcer l'écrasement des fichiers sans avertissement |

---

### 🌍 Localisation

Les fichiers de langue sont ici :

```
app/Language/en/CrudGenerator.php
app/Language/fr/CrudGenerator.php
```

Vous pouvez les modifier ou en ajouter d'autres.

---

### 📁 Structure générée

```
app/
├── Controllers/
│   └── ProduitController.php
├── Entities/
│   └── Produit.php
├── Models/
│   └── ProduitModel.php
├── Views/
│   ├── produit/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── show.php
│   └── templates/
│       ├── header.php
│       └── footer.php
├── Database/
│   └── Migrations/
│       └── 2025-01-01-CreateProduitTable.php
```

---

### 🛡️ Sécurités

- Vérifie si le CRUD existe déjà
- Préviens si une table est déjà présente dans la BDD
- Demande avant de remplacer un fichier
- `--force` pour tout automatiser

---

### 📝 Licence

Licence MIT — Utilisation libre et modification autorisée.
