<?php
namespace EWallet\Service;

use EWallet\Repository;

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

function creerWalletService(array &$wallets, string $client, string $telephone, string $code, int $solde): int {
    $nouveau = [
        "client" => $client,
        "telephone" => $telephone,
        "code" => $code,
        "solde" => $solde
    ];
    return Repository\ajouterWallet($wallets, $nouveau);
}

function faireDepotService(array &$wallets, array &$transactions, string $telephone, int $montant): int {
    $index = Repository\trouverWallet($telephone, $wallets);
    if ($index === -1) {
        return 11;
    }
    if ($montant <= 0) {
        return 11;
    }
    $nouveauSolde = $wallets[$index]["solde"] + $montant;
    Repository\mettreAJourSolde($wallets, $index, $nouveauSolde);
    $trans = [
        "type" => "Dépôt",
        "telephone" => $telephone,
        "client" => $wallets[$index]["client"],
        "montant" => $montant,
        "frais" => 0,
        "solde_apres" => $nouveauSolde,
        "date" => date('Y-m-d H:i:s')
    ];
    Repository\ajouterTransaction($transactions, $trans);
    return 10;
}

function faireRetraitService(array &$wallets, array &$transactions, string $telephone, int $montant, int &$fraisCalcules, int &$soldeApresRetrait): int {
    $index = Repository\trouverWallet($telephone, $wallets);
    if ($index === -1) {
        return 11;
    }
    if ($montant <= 0) {
        return 11;
    }
    $frais = calculerFrais($montant);
    $total = $montant + $frais;
    if ($total > $wallets[$index]["solde"]) {
        return 11;
    }
    $nouveauSolde = $wallets[$index]["solde"] - $total;
    Repository\mettreAJourSolde($wallets, $index, $nouveauSolde);
    $fraisCalcules = $frais;
    $soldeApresRetrait = $nouveauSolde;
    $trans = [
        "type" => "Retrait",
        "telephone" => $telephone,
        "client" => $wallets[$index]["client"],
        "montant" => $montant,
        "frais" => $frais,
        "solde_apres" => $nouveauSolde,
        "date" => date('Y-m-d H:i:s')
    ];
    Repository\ajouterTransaction($transactions, $trans);
    return 10;
}
