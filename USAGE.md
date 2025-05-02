# 🚀 USAGE.md

Choose your language / Choisissez votre langue :
- [🇬🇧 English](#-english-version)
- [🇫🇷 Français](#-version-française)

---

## 🇬🇧 English version

### 📦 Command Overview

```bash
php spark make:crud [options]
```

---

### 🛠️ Available Options

| Option       | Description                                  |
|--------------|----------------------------------------------|
| `--force`    | Automatically overwrite existing files.      |
| `-f`         | Shorthand for `--force`.                     |

---

### 🧩 What It Generates

- `Model` in `app/Models/`
- `Entity` in `app/Entities/`
- `Controller` in `app/Controllers/`
- `Views` (`index.php`, `create.php`, `edit.php`, `show.php`) in `app/Views/{entity}/`
- `Migration` in `app/Database/Migrations/`
- Shared `header.php` and `footer.php` in `app/Views/templates/`

---

### 🧭 Interactive Flow

1. Prompt: Entity name
2. Prompt: Field names, types, constraints
3. Prompt: Confirmations for overwrites (if file exists)
4. Summary is displayed with what was generated or skipped

---

### 🛡️ Best Practices

- Use clear and valid entity names (avoid PHP reserved keywords).
- Validate each input to maintain CI4 standards.
- Customize generated files as needed — the structure is made to be developer-friendly.
- Use `--force` only when you're sure about overwriting.

---

### 🌐 Localization

Translations can be modified in:

- `app/Language/en/CrudGenerator.php`
- `app/Language/fr/CrudGenerator.php`

Add your own locale files to extend.

---

### 📝 License

MIT — Feel free to use and modify.

---

## 🇫🇷 Version française

### 📦 Commande de base

```bash
php spark make:crud [options]
```

---

### 🛠️ Options disponibles

| Option       | Description                                         |
|--------------|-----------------------------------------------------|
| `--force`    | Écrase automatiquement les fichiers existants.      |
| `-f`         | Raccourci pour `--force`.                           |

---

### 🧩 Ce que ça génère

- `Model` dans `app/Models/`
- `Entity` dans `app/Entities/`
- `Controller` dans `app/Controllers/`
- `Views` (`index.php`, `create.php`, `edit.php`, `show.php`) dans `app/Views/{entity}/`
- `Migration` dans `app/Database/Migrations/`
- Templates partagés `header.php` et `footer.php` dans `app/Views/templates/`

---

### 🧭 Déroulement interactif

1. Saisie : nom de l’entité
2. Saisie : champs, types, contraintes
3. Confirmation : remplacement si les fichiers existent
4. Résumé final avec ce qui a été généré ou ignoré

---

### 🛡️ Bonnes pratiques

- Utilisez des noms d’entité clairs et valides (évitez les mots réservés PHP).
- Validez chaque champ pour rester cohérent avec CI4.
- Personnalisez les fichiers générés selon vos besoins.
- Utilisez `--force` uniquement si vous êtes sûr de ce que vous faites.

---

### 🌐 Localisation

Les fichiers de langue sont modifiables dans :

- `app/Language/en/CrudGenerator.php`
- `app/Language/fr/CrudGenerator.php`

Vous pouvez aussi ajouter d’autres fichiers pour d’autres langues.

---

### 📝 Licence

MIT — Utilisation et modification libres.
