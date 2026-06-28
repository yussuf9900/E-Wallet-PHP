<?php
namespace EWallet\Repository;

function trouverWallet(string $telephone, array $wallets): int {
    $found = array_filter($wallets, function(array $w) use ($telephone): bool {
        return $w["telephone"] === $telephone;
    });
    if (count($found) === 0) {
        return -1;
    }
    $keys = array_keys($found);
    return $keys[0];
}

function telephoneEstUnique(string $telephone, array $wallets): int {
    $index = trouverWallet($telephone, $wallets);
    return $index === -1 ? 10 : 11;
}

function codeEstUnique(string $code, array $wallets): int {
    $found = array_filter($wallets, function(array $w) use ($code): bool {
        return $w["code"] === $code;
    });
    return count($found) === 0 ? 10 : 11;
}

function ajouterWallet(array &$wallets, array $nouveauWallet): int {
    $wallets[] = $nouveauWallet;
    return 10;
}

function mettreAJourSolde(array &$wallets, int $index, int $nouveauSolde): int {
    $wallets[$index]["solde"] = $nouveauSolde;
    return 10;
}

function ajouterTransaction(array &$transactions, array $nouvelleTrans): int {
    $transactions[] = $nouvelleTrans;
    return 10;
}
