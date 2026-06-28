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
