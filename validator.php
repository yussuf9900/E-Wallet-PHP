<?php
// validator.php - Regroupe toutes les fonctions de validation

function estChiffre(string $chaine): int {
    if ($chaine === "") {
        return 11;
    }
    $chars = str_split($chaine);
    $invalidChars = array_filter($chars, function(string $c): bool {
        return $c < '0' || $c > '9';
    });
    return count($invalidChars) === 0 ? 10 : 11;
}

function estDecimalValide(string $saisie): int {
    if ($saisie === "") {
        return 11;
    }
    $chars = str_split($saisie);
    $pointCount = count(array_filter($chars, function(string $c): bool {
        return $c === '.';
    }));
    if ($pointCount > 1) {
        return 11;
    }
    $invalidChars = array_filter($chars, function(string $c): bool {
        return $c !== '.' && ($c < '0' || $c > '9');
    });
    return count($invalidChars) === 0 ? 10 : 11;
}

function validerTelephone(string $telephone): int {
    if (strlen($telephone) !== 9) {
        return 11;
    }
    if (estChiffre($telephone) === 11) {
        return 11;
    }
    $prefixe = substr($telephone, 0, 2);
    $prefixes = ["77", "78", "76", "70", "75"];
    $found = array_filter($prefixes, function(string $p) use ($prefixe): bool {
        return $p === $prefixe;
    });
    return count($found) > 0 ? 10 : 11;
}

function validerCodeSecret(string $code): int {
    if (strlen($code) !== 4) {
        return 11;
    }
    if (estChiffre($code) === 11) {
        return 11;
    }
    return 10;
}

function validerNom(string $nom): int {
    return $nom !== "" ? 10 : 11;
}

function validerMontant(string $montant): int {
    if (estChiffre($montant) === 11) {
        return 11;
    }
    $valeur = (int)$montant;
    if ($valeur < 0) {
        return 11;
    }
    return 10;
}

function validerMontantStrictementPositif(string $montant): int {
    if (estChiffre($montant) === 11) {
        return 11;
    }
    $valeur = (int)$montant;
    if ($valeur <= 0) {
        return 11;
    }
    return 10;
}


function validerSoldeDisponible(int $soldeActuel, int $montant, int $frais): int {
    if ($soldeActuel < ($montant + $frais)) {
        return 11;
    }
    return 10;
}

function estTelephoneUnique(array &$wallets, string $telephone): int {
    $found = array_filter($wallets, function(array $w) use ($telephone): bool {
        return $w['telephone'] === $telephone;
    });
    return count($found) === 0 ? 10 : 11;
}

function estCodeUnique(array &$wallets, string $code): int {
    $found = array_filter($wallets, function(array $w) use ($code): bool {
        return $w['code'] === $code;
    });
    return count($found) === 0 ? 10 : 11;
}

