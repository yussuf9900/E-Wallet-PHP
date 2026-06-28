<?php
// validator.php - Regroupe toutes les fonctions de validation

function estNumerique(string $valeur): int {
    $longueur = strlen($valeur);
    if ($longueur === 0) {
        return 11;
    }
    for ($i = 0; $i < $longueur; $i++) {
        $char = $valeur[$i];
        if ($char < '0' || $char > '9') {
            return 11;
        }
    }
    return 10;
}

function validerTelephone(string $telephone): int {
    if (strlen($telephone) !== 9) {
        return 11;
    }
    if (estNumerique($telephone) === 11) {
        return 11;
    }
    $prefix = substr($telephone, 0, 2);
    if ($prefix === '77' || $prefix === '78' || $prefix === '76' || $prefix === '70' || $prefix === '75') {
        return 10;
    }
    return 11;
}

function validerCodeSecret(string $code): int {
    if (strlen($code) !== 4) {
        return 11;
    }
    if (estNumerique($code) === 11) {
        return 11;
    }
    return 10;
}

function validerNom(string $nom): int {
    if ($nom === '') {
        return 11;
    }
    return 10;
}

function validerMontant(string $montant): int {
    if (estNumerique($montant) === 11) {
        return 11;
    }
    $valeur = (int)$montant;
    if ($valeur < 0) {
        return 11;
    }
    return 10;
}

function validerMontantStrictementPositif(string $montant): int {
    if (estNumerique($montant) === 11) {
        return 11;
    }
    $valeur = (int)$montant;
    if ($valeur <= 0) {
        return 11;
    }
    return 10;
}

function estTelephoneUnique(array &$wallets, string $telephone): int {
    foreach ($wallets as $wallet) {
        if ($wallet['telephone'] === $telephone) {
            return 11; // Non unique
        }
    }
    return 10; // Unique
}

function estCodeUnique(array &$wallets, string $code): int {
    foreach ($wallets as $wallet) {
        if ($wallet['code'] === $code) {
            return 11; // Non unique
        }
    }
    return 10; // Unique
}

function validerSoldeDisponible(int $soldeActuel, int $montant, int $frais): int {
    if ($soldeActuel < ($montant + $frais)) {
        return 11;
    }
    return 10;
}

