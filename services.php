<?php
// services.php - Contient la logique métier (Business Logic)

function tenterCreerWallet(array &$wallets, string $telephone, string $nom, int $solde, string $code): int {
    if (validerTelephone($telephone) === 11) {
        return 11;
    }
    if (estTelephoneUnique($wallets, $telephone) === 11) {
        return 12;
    }
    if (validerNom($nom) === 11) {
        return 13;
    }
    if ($solde < 0) {
        return 14;
    }
    if (validerCodeSecret($code) === 11) {
        return 15;
    }
    if (estCodeUnique($wallets, $code) === 11) {
        return 16;
    }

    $nouveauWallet = [
        'telephone' => $telephone,
        'nom' => $nom,
        'solde' => $solde,
        'code' => $code
    ];
    ajouterWallet($wallets, $nouveauWallet);
    return 10;
}

function tenterDepot(array &$wallets, array &$transactions, string $telephone, int $montant): int {
    $index = trouverIndexWallet($wallets, $telephone);
    if ($index === -1) {
        return 11;
    }
    if ($montant <= 0) {
        return 12;
    }

    $nouveauSolde = $wallets[$index]['solde'] + $montant;
    mettreAjourSolde($wallets, $index, $nouveauSolde);
    ajouterTransaction($transactions, 'depot', $telephone, $montant, 0);
    return 10;
}

function calculerFrais(int $montant): int {
    if ($montant <= 10000) {
        return 200;
    }
    if ($montant <= 100000) {
        return 500;
    }
    $frais = (int)($montant * 0.01);
    if ($frais > 5000) {
        return 5000;
    }
    return $frais;
}

function tenterRetrait(array &$wallets, array &$transactions, string $telephone, int $montant): int {
    $index = trouverIndexWallet($wallets, $telephone);
    if ($index === -1) {
        return 11;
    }
    if ($montant <= 0) {
        return 12;
    }

    $frais = calculerFrais($montant);
    $totalDebite = $montant + $frais;

    if (validerSoldeDisponible($wallets[$index]['solde'], $montant, $frais) === 11) {
        return 13;
    }

    $nouveauSolde = $wallets[$index]['solde'] - $totalDebite;
    mettreAjourSolde($wallets, $index, $nouveauSolde);
    ajouterTransaction($transactions, 'retrait', $telephone, $montant, $frais);
    return 10;
}


