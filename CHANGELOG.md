
# 📦 CHANGELOG

Choose your language / Choisissez votre langue :
- [🇬🇧 English](#-english)
- [🇫🇷 Français](#-français)

---

## 🇬🇧 English

### [1.0.2] - 2025-05-02

#### Added
- ✨ `crud:publish-lang` command to publish language files to `app/Language`.
- 🛠 Composer autoload and `extra.codeigniter4.discoverable` support.
- 📦 `INSTALL.md` added for Composer usage.
- 🌐 Full rework of manual/Composer installation in README.

#### Changed
- 🧹 Cleaned service provider (replaced by publish command).

#### Removed
- ❌ Legacy `CrudGeneratorServiceProvider` removed.

---

### [1.0.1] - 2025-05-02

#### Added
- Display of routes to copy in `Routes.php` after generation.
- Clickable link to access the generated CRUD interface.
- Prompt to automatically run `php spark migrate` after generation.
- `editItem` language line added for dynamic titles.
- Page titles internationalized (`Edit`, `Create`, etc.).

#### Changed
- Entity data access switched from array syntax (`['field']`) to object syntax (`->field`).
- Language files reorganized and sorted with block comments.
- Added inline comments in language files for better readability.

#### Fixed
- Critical bug: `Cannot use object as array` in `index.php` view fixed.
- HTML constant error in `edit.php` view resolved.
- Missing translation in `edit.php` view (`Edit`) corrected.

---

### [1.0.0] - 2025-05-01

#### Added
- Initial stable release of the CodeIgniter 4 CRUD generator.
- Support for Model, Entity, Controller, Views, and Migration file generation.
- Interactive CLI prompts for fields and validation.
- File overwrite protection with `--force` support.
- Multilingual support (English & French).
- Fully documented command with summary report after execution.

#### Changed
- N/A

#### Fixed
- N/A

---

## 🇫🇷 Français

### [1.0.2] - 2025-05-02

#### Ajouts
- ✨ Commande `crud:publish-lang` pour publier les fichiers de langue dans `app/Language`.
- 🛠 Support Composer autoload et `extra.codeigniter4.discoverable`.
- 📦 Fichier `INSTALL.md` pour installation via Composer.
- 🌐 Documentation révisée pour installation manuelle/Composer.

#### Modifications
- 🧹 Nettoyage du provider (remplacé par la commande `crud:publish-lang`).

#### Suppressions
- ❌ Suppression du fichier `CrudGeneratorServiceProvider`.

---

### [1.0.1] - 2025-05-02

#### Ajouts
- Affichage des routes à copier dans `Routes.php` après la génération.
- Lien cliquable vers l’interface CRUD générée.
- Question pour exécuter `php spark migrate` automatiquement.
- Ligne `editItem` ajoutée dans les fichiers de langue.
- Internationalisation des titres de pages (`Modifier`, `Créer`, etc.).

#### Modifications
- Passage de l’accès aux entités en syntaxe objet (`->champ`).
- Réorganisation des fichiers de langue avec tri et commentaires.
- Ajout de commentaires dans les fichiers de langue pour plus de clarté.

#### Corrections
- Bug critique corrigé : `Cannot use object as array` dans la vue `index.php`.
- Erreur de constante HTML corrigée dans la vue `edit.php`.
- Traduction manquante dans la vue `edit.php` corrigée (`Modifier`).

---

### [1.0.0] - 2025-05-01

#### Ajouts
- Version stable initiale du générateur CRUD pour CodeIgniter 4.
- Génération de Model, Entity, Controller, Views et Migration.
- Invite interactive en CLI pour les champs et la validation.
- Protection contre l’écrasement avec l’option `--force`.
- Support multilingue (Anglais et Français).
- Résumé complet après exécution de la commande.

#### Modifications
- N/A

#### Corrections
- N/A
