<?php
// index.php - Point d'entrée de l'application

require_once 'validator.php';
require_once 'repository.php';
require_once 'services.php';
require_once 'controller.php';

$wallets = [];
$transactions = [];
$continuer = 10;

do {
    afficherMenu();
    $choix = lireSaisie("Votre choix : ");
    $continuer = routerAction($choix, $wallets, $transactions);
} while ($continuer === 10);
