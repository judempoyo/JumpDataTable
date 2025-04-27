# Contribution Guidelines / Guide de contribution

---

## 🌐 Table of Contents / Table des matières

- [Contribution Guidelines / Guide de contribution](#contribution-guidelines--guide-de-contribution)
  - [🌐 Table of Contents / Table des matières](#-table-of-contents--table-des-matières)
  - [🇫🇷 Français](#-français)
    - [Structure du projet](#structure-du-projet)
    - [Processus de contribution](#processus-de-contribution)
    - [Conventions de code](#conventions-de-code)
    - [Tests](#tests)
    - [Documentation](#documentation)
  - [🇬🇧 English](#-english)
    - [Project Structure](#project-structure)
    - [Contribution Process](#contribution-process)
    - [Code Conventions](#code-conventions)
    - [Testing](#testing)
    - [Documentation](#documentation-1)
    - [📝 Notes](#-notes)

---

## 🇫🇷 Français

### Structure du projet
src/
├── DataTable.php # Classe principale
├── DataColumn.php # Gestion des colonnes
├── DataAction.php # Gestion des actions
├── Filter.php # Système de filtrage
├── Pagination.php # Gestion de la pagination
├── Themes/ # Dossiers des thèmes
│ ├── TailwindTheme.php
│ └── BootstrapTheme.php
tests/ # Tests unitaires
docs/ # Documentation


### Processus de contribution

1. **Fork** le dépôt
2. Créez une branche :  
   `git checkout -b feature/ma-nouvelle-fonctionnalite`
3. Commitez vos changements :  
   `git commit -m "feat: ajout d'une nouvelle fonctionnalité"`
4. Poussez vers la branche :  
   `git push origin feature/ma-nouvelle-fonctionnalite`
5. Ouvrez une **Pull Request**

### Conventions de code

- Respectez le style PSR-12
- Typage strict partout
- Documentez avec PHPDoc
- Messages de commit conventionnels :
  - `feat:` pour les nouvelles fonctionnalités
  - `fix:` pour les corrections de bugs
  - `docs:` pour la documentation

### Tests

Exécutez les tests avant de soumettre :

```bash
composer test
```
Couverture de code visée : 90% minimum

### Documentation

Mettez à jour :

1. Le README.md
2. Les fichiers dans docs/
3. Les annotations PHPDoc

## 🇬🇧 English
### Project Structure
src/
├── DataTable.php          # Main class
├── DataColumn.php         # Columns management
├── DataAction.php         # Actions management
├── Filter.php            # Filtering system
├── Pagination.php        # Pagination handling
├── Themes/               # Theme folders
│   ├── TailwindTheme.php
│   └── BootstrapTheme.php
tests/                    # Unit tests
docs/                     # Documentation

### Contribution Process
1. Fork the repository
2. Create your branch:
   `git checkout -b feature/my-new-feature`
3. Commit your changes:
   `git commit -m "feat: add new feature"`
4. Push to the branch:
   `git push origin feature/my-new-feature`
5. Open a Pull Request

### Code Conventions

- Follow PSR-12 style
- Strict typing everywhere
- Document with PHPDoc
- Conventional commit messages:
  - `feat`: for new features
  - `fix`: for bug fixes
  - `docs`: for documentation

### Testing
Run tests before submitting:

```bash
composer test
```
Target code coverage: 90% minimum

### Documentation
Update:

1. README.md
2. Files in docs/
3. PHPDoc annotations

### 📝 Notes
- Les contributions concernant les nouveaux thèmes sont particulièrement bienvenues
- Theme-related contributions are especially welcome
- Pour les grandes modifications, ouvrez d'abord une issue pour discussion
- For major changes, please open an issue first to discuss