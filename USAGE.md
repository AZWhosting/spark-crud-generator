
# 🚀 USAGE.md

This document explains how to use the `make:crud` command for CodeIgniter 4.

---

## 📦 Command Overview

```bash
php spark make:crud [options]
```

---

## 🛠️ Available Options

| Option       | Description                                  |
|--------------|----------------------------------------------|
| `--force`    | Automatically overwrite existing files.      |
| `-f`         | Shorthand for `--force`.                     |

---

## 🧩 What It Generates

- `Model` in `app/Models/`
- `Entity` in `app/Entities/`
- `Controller` in `app/Controllers/`
- `Views` (`index.php`, `create.php`, `edit.php`, `show.php`) in `app/Views/{entity}/`
- `Migration` in `app/Database/Migrations/`
- Shared `header.php` and `footer.php` in `app/Views/templates/`

---

## 🧭 Interactive Flow

1. Prompt: Entity name
2. Prompt: Field names, types, constraints
3. Prompt: Confirmations for overwrites (if file exists)
4. Summary is displayed with what was generated or skipped

---

## 🛡️ Best Practices

- Use clear and valid entity names (avoid PHP reserved keywords).
- Validate each input to maintain CI4 standards.
- Customize generated files as needed — the structure is made to be developer-friendly.
- Use `--force` only when you're sure about overwriting.

---

## 🌐 Localization

Translations can be modified in:

- `app/Language/en/CrudGenerator.php`
- `app/Language/fr/CrudGenerator.php`

Add your own locale files to extend.

---



## 🎨 Template Themes

At startup, you'll be prompted to select a theme (folder in `resources/templates/`).

To create your own:
- Copy `resources/templates/default/` into a new folder (e.g. `bootstrap/`)
- Edit any `.tpl` file: `controller.tpl`, `model.tpl`, etc.

---

## 🔄 Automatic Route Injection

At the end of the generation, you're asked if routes should be added automatically into `app/Config/Routes.php`.

- If accepted, routes from `route.tpl` are appended.
- Backup of `Routes.php` is created.
- Manual route suggestion is always displayed as fallback.


## 📝 License

MIT — Feel free to use and modify.
