# 📱 Système de Gestion de Portefeuille Électronique (E-Wallet)

Bienvenue dans le projet **E-Wallet**, une application console écrite en PHP simulant le fonctionnement d'un distributeur de services financiers (Mobile Money). Ce projet a été réalisé en deux phases d'apprentissage progressif (Partie A et Partie B) pour consolider les fondamentaux de l'algorithmique puis professionnaliser l'architecture.

---

## 📂 Organisation du Dépôt & Documents Associés

Pour faciliter la navigation et l'évaluation, la documentation et les supports de présentation ont été structurés comme suit :

1. **[README.md](file:///home/ichigo/Bureau/ODC-PROJETS/PHP/E-Wallet/README.md)** : Ce guide d'accueil et d'utilisation global.
2. **[PRESENTATION_Partie_A.md](file:///home/ichigo/Bureau/ODC-PROJETS/PHP/E-Wallet/PRESENTATION_Partie_A.md)** : Support de présentation orale du **Sprint 1 (Partie A)**, axé sur les bases du PHP procédural, la manipulation manuelle des tableaux, et la validation stricte.
3. **[PRESENTATION_Partie_B.md](file:///home/ichigo/Bureau/ODC-PROJETS/PHP/E-Wallet/PRESENTATION_Partie_B.md)** : Support de présentation technique de la **Partie B**, détaillant la refactorisation (Closures, fonctions natives `array_*`, Namespaces, Composer et Packagist).

---

## 🏗️ Architecture du Code (Partie B)

Dans sa version finale (v2.0.0), l'application suit une architecture modulaire propre :

```text
E-Wallet/
├── vendor/                   # Dépendances et autoloader Composer
├── composer.json             # Déclaration des dépendances et de l'autoloading
├── composer.lock             # Fichier de verrouillage des versions
├── index.php                 # Point d'entrée principal (boucle de menu)
├── controller.php            # Contrôleur d'interaction utilisateur (E/S console)
├── services.php              # Logique métier et calculs (Frais, etc.)
├── repository.php            # Persistance mémoire et gestion de données
└── validator.php             # Validations des règles de gestion
```

Chaque fichier possède un rôle précis et utilise le Namespace racine `EWallet`.

---

## 🚀 Comment Exécuter l'Application

### Prérequis
- **PHP** (version 8.0 ou supérieure recommandée)
- **Composer** (pour gérer l'autoloading des namespaces)

### Installation et initialisation
1. Clonez ou placez-vous dans le répertoire du projet :
   ```bash
   cd /home/ichigo/Bureau/ODC-PROJETS/PHP/E-Wallet
   ```
2. Installez les dépendances Composer et générez l'autoloader :
   ```bash
   composer install
   ```

### Lancement
Pour démarrer le simulateur en mode console :
```bash
php index.php
```

---

## 🛠️ Fonctionnalités du Simulateur
- **Création de Wallet** : Enregistrement d'un client avec nom, téléphone unique (format Sénégal), code secret unique (4 chiffres) et solde initial positif ou nul.
- **Dépôt de fonds** : Crédit d'un wallet existant d'un montant strictement positif.
- **Retrait de fonds** : Débit d'un wallet avec calcul automatique et plafonné des frais de transaction.
- **Historique des Transactions** : Liste complète des mouvements ou filtrée par numéro de téléphone.

---

> [!NOTE]
> Ce projet s'inscrit dans un parcours pédagogique visant à enseigner les bonnes pratiques de versioning (Git/SemVer) et de structuration logicielle. Les présentations détaillées sont accessibles via les liens ci-dessus.
