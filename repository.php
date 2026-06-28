<?php
// repository.php - Dédié à la persistance et l'accès aux données en mémoire

function trouverIndexWallet(array &$wallets, string $telephone): int {
    $index = 0;
    foreach ($wallets as $wallet) {
        if ($wallet['telephone'] === $telephone) {
            return $index;
        }
        $index = $index + 1;
    }
    return -1;
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
    $filtrees = [];
    foreach ($transactions as $t) {
        if ($t['telephone'] === $telephone) {
            $filtrees[] = $t;
        }
    }
    return $filtrees;
}


