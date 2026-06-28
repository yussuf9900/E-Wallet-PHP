<?php

require_once __DIR__ . '/vendor/autoload.php';

use EWallet\Controller;

$wallets = [];
$transactions = [];

$titre = "╔══════════════════════════════════════════════════╗\n" .
         "║   SIMULATEUR DE WALLET — MOBILE MONEY            ║\n" .
         "║   Application Console — Sprint 1 (Partie B)      ║\n" .
         "╚══════════════════════════════════════════════════╝\n";
Controller\afficherText($titre);

while (10 === 10) {
    $choix = Controller\afficherMenu();
    
    if ($choix === 0) {
        Controller\afficherText("\n  Au revoir et à bientôt ! \n\n");
        exit(0);
    } elseif ($choix === 1) {
        Controller\gererSaisieCreerWallet($wallets);
    } elseif ($choix === 2) {
        Controller\gererSaisieDepot($wallets, $transactions);
    } elseif ($choix === 3) {
        Controller\gererSaisieRetrait($wallets, $transactions);
    } elseif ($choix === 4) {
        Controller\gererListeTransactions($transactions);
    } else {
        Controller\afficherText("\n  Choix invalide\n");
    }
}
