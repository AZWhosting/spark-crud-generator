# 🚀 Release Notes — Version 1.1.0

## 📦 Overview

This release introduces a **modular refactoring** of the Spark CRUD generator for CodeIgniter 4, built with customization, maintainability, and developer experience in mind.

---

## ✨ Highlights

- 🧩 **Modular Architecture**: Each component (Model, Controller, Entity, Views, Migration) is handled by its own generator class.
- 🎨 **Themed Templates**: Use or create `.tpl` template sets for fully customized CRUD output (`default`, `bootstrap`, etc.)
- 🌐 **Internationalization**: All views and messages are fully localized (FR/EN).
- 🔄 **Automatic Route Injection**: Detects and inserts route definitions into `Routes.php`, with safety checks.
- 📄 **Documentation Rewritten**: README, USAGE, and CHANGELOG all reflect the new modular template system.

---

## ✅ New Commands

- `php spark make:crud` — Fully interactive CRUD generation
- `php spark crud:publish-lang` — Publishes language files to `app/Language`

---

## 🧪 Safe by Design

- No overwrite without confirmation
- `--force` option available to bypass prompts
- Route deduplication to avoid breaking `Routes.php`
- Backup of overwritten files (`Routes.php`)

---

## 🔁 Upgrade Guide

If you're upgrading from 1.0.x:
- No breaking changes in structure
- Your existing templates and customizations remain safe
- Be sure to run:  
  ```bash
  php spark crud:publish-lang
  ```

---

## 📝 License

MIT — Free to use and modify.