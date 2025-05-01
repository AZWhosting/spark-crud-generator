# 🌐 CodeIgniter 4 Interactive CRUD Generator

Choose your language / Choisissez votre langue :
- [🇬🇧 English](#-english-version)
- [🇫🇷 Français](#-version-française)

---

## 🇬🇧 English version

### 📚 Table of Contents

- [✨ Features](#-features)
- [⚙️ Installation](#️-installation)
- [🚀 Usage](#-usage)
- [📄 Options](#-options)
- [🌍 Localization](#-localization)
- [📁 Generated Structure](#-generated-structure)
- [🛡️ Safeguards](#️-safeguards)
- [📝 License](#-license)

---

### ✨ Features

- Generates **Model, Entity, Controller, Views, Migration**
- Interactive prompts for field definitions
- Language support (English & French)
- No file overwrite without confirmation
- `--force` mode to skip confirmations
- Clean structure: templates and CRUD folders

---

### ⚙️ Installation

Put the generator in:

```
app/Commands/MakeCrud.php
```

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
- [⚙️ Installation](#️-installation-1)
- [🚀 Utilisation](#-utilisation)
- [📄 Options](#-options-1)
- [🌍 Localisation](#-localisation)
- [📁 Structure générée](#-structure-générée)
- [🛡️ Sécurités](#️-sécurités)
- [📝 Licence](#-licence)

---

### ✨ Fonctionnalités

- Génère **Modèle, Entité, Contrôleur, Vues, Migration**
- Interface interactive pour les champs
- Prise en charge de plusieurs langues (FR / EN)
- Aucun fichier écrasé sans confirmation
- Mode `--force` pour tout passer en force
- Structure claire : templates et vues par entité

---

### ⚙️ Installation

Placez le fichier dans :

```
app/Commands/MakeCrud.php
```

Puis exécutez-le via Spark CLI.

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
