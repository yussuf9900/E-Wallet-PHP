<?php
// repository.php - Dédié à la persistance et l'accès aux données en mémoire

function trouverIndexWallet(array &$wallets, string $telephone): int {
    $found = array_filter($wallets, function(array $w) use ($telephone): bool {
        return $w["telephone"] === $telephone;
    });
    if (count($found) === 0) {
        return -1;
    }
    $keys = array_keys($found);
    return $keys[0];
}

function ajouterWallet(array &$wallets, array $wallet): void {
    $wallets[] = $wallet;
}

function mettreAjourSolde(array &$wallets, int $index, int $nouveauSolde): void {
    $wallets[$index]['solde'] = $nouveauSolde;
}

function ajouterTransaction(array &$transactions, string $type, string $telephone, int $montant, int $frais): void {
    $transactions[] = [
        'type' => $type,
        'telephone' => $telephone,
        'montant' => $montant,
        'frais' => $frais,
        'date' => date('Y-m-d H:i:s')
    ];
}

function obtenirTransactionsParTelephone(array &$transactions, string $telephone): array {
    return array_filter($transactions, function(array $t) use ($telephone): bool {
        return $t['telephone'] === $telephone;
    });
}
