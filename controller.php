<?php
// controller.php - Intermédiaire (routeur de logique)

function afficherText(string $message): void {
    echo $message;
}

function lireSaisie(string $invite): string {
    afficherText($invite);
    return readline();
}

function afficherMenu(): void {
    afficherText("\n** Menu Distributeur **\n");
    afficherText("1 - Créer Wallet\n");
    afficherText("2 - Faire Dépôt\n");
    afficherText("3 - Faire Retrait\n");
    afficherText("4 - Lister les Transactions\n");
    afficherText("0 - Quitter\n");
}

function controllerCreerWallet(array &$wallets): void {
    $telephone = lireSaisie("Entrez le numéro de téléphone (Sénégal, 9 chiffres) : ");
    if (validerTelephone($telephone) === 11) {
        afficherText("Erreur : Numéro de téléphone invalide.\n");
        return;
    }
    if (estTelephoneUnique($wallets, $telephone) === 11) {
        afficherText("Erreur : Ce numéro de téléphone existe déjà.\n");
        return;
    }

    $nom = lireSaisie("Entrez le nom du client : ");
    if (validerNom($nom) === 11) {
        afficherText("Erreur : Le nom est obligatoire.\n");
        return;
    }

    $soldeString = lireSaisie("Entrez le solde initial (>= 0) : ");
    if (validerMontant($soldeString) === 11) {
        afficherText("Erreur : Solde initial invalide (doit être un entier positif ou nul).\n");
        return;
    }
    $solde = (int)$soldeString;

    $code = lireSaisie("Entrez le code secret (4 chiffres) : ");
    if (validerCodeSecret($code) === 11) {
        afficherText("Erreur : Le code secret doit comporter exactement 4 chiffres.\n");
        return;
    }
    if (estCodeUnique($wallets, $code) === 11) {
        afficherText("Erreur : Ce code secret existe déjà.\n");
        return;
    }

    $resultat = tenterCreerWallet($wallets, $telephone, $nom, $solde, $code);
    if ($resultat === 10) {
        afficherText("Succès : Le wallet a été créé avec succès !\n");
    } else {
        afficherText("Erreur lors de la création du wallet.\n");
    }
}

function routerAction(string $choix, array &$wallets, array &$transactions): int {
    if ($choix === '0') {
        afficherText("Au revoir !\n");
        return 11; // stop
    }

    switch ($choix) {
        case '1':
            controllerCreerWallet($wallets);
            break;
        case '2':
            afficherText("Option 2 choisie (Faire Dépôt)\n");
            break;
        case '3':
            afficherText("Option 3 choisie (Faire Retrait)\n");
            break;
        case '4':
            afficherText("Option 4 choisie (Lister les Transactions)\n");
            break;
        default:
            afficherText("Choix invalide, veuillez réessayer\n");
            break;
    }

    return 10; // continue
}

