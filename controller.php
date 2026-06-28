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

function routerAction(string $choix, array &$wallets, array &$transactions): int {
    if ($choix === '0') {
        afficherText("Au revoir !\n");
        return 11; // stop
    }

    switch ($choix) {
        case '1':
            afficherText("Option 1 choisie (Créer Wallet)\n");
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
