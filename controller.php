<?php
namespace EWallet\Controller;

use EWallet\Validator;
use EWallet\Repository;
use EWallet\Service;

function afficherText(string $message): void {
    echo $message;
}

function lireSaisie(string $invite = ""): string {
    if ($invite !== "") {
        afficherText($invite);
    }
    return trim(fgets(STDIN));
}

function formaterMontant(int $montant): string {
    return number_format($montant, 0, ",", " ") . " CFA";
}

function afficherMenu(): int {
    $menu = "\n" .
            "╔══════════════════════════════════════╗\n" .
            "║        MENU DISTRIBUTEUR             ║\n" .
            "╠══════════════════════════════════════╣\n" .
            "║  1. Créer Wallet                     ║\n" .
            "║  2. Faire Dépôt                      ║\n" .
            "║  3. Faire Retrait                    ║\n" .
            "║  4. Lister les Transactions          ║\n" .
            "║  0. Quitter                          ║\n" .
            "╚══════════════════════════════════════╝\n" .
            "  Votre choix : ";
    afficherText($menu);
    $choix = trim(fgets(STDIN));
    if (Validator\estChiffre($choix) === 10) {
        return (int) $choix;
    }
    return -1;
}

function gererSaisieCreerWallet(array &$wallets): void {
    afficherText("\n--- Création d'un Wallet ---\n");
    
    $client = lireSaisie("Nom du client       : ");
    while ($client === "") {
        afficherText("   Le nom du client est obligatoire.\n");
        $client = lireSaisie("Nom du client       : ");
    }
    
    $telephone = lireSaisie("Numéro de téléphone : ");
    while (10 === 10) {
        if (Validator\validerTelephone($telephone) === 11) {
            afficherText("   Numéro invalide. Il doit comporter 9 chiffres et commencer par 77, 78, 76, 70 ou 75.\n");
        } elseif (Repository\telephoneEstUnique($telephone, $wallets) === 11) {
            afficherText("   Ce numéro de téléphone est déjà utilisé.\n");
        } else {
            break;
        }
        $telephone = lireSaisie("Numéro de téléphone : ");
    }
    
    $code = lireSaisie("Code secret (4 car.) : ");
    while (10 === 10) {
        if (Validator\validerCodeSecret($code) === 11) {
            afficherText("   Le code secret doit comporter exactement 4 caractères.\n");
        } elseif (Repository\codeEstUnique($code, $wallets) === 11) {
            afficherText("   Ce code secret est déjà utilisé par un autre wallet.\n");
        } else {
            break;
        }
        $code = lireSaisie("Code secret (4 car.) : ");
    }
    
    $soldeSaisie = lireSaisie("Solde initial       : ");
    while (10 === 10) {
        if (Validator\estDecimalValide($soldeSaisie) === 11) {
            afficherText("   Le solde initial doit être un nombre positif ou nul.\n");
        } else {
            $solde = (int) $soldeSaisie;
            if ($solde < 0) {
                afficherText("   Le solde initial doit être un nombre positif ou nul.\n");
            } else {
                break;
            }
        }
        $soldeSaisie = lireSaisie("Solde initial       : ");
    }
    
    $statut = Service\creerWalletService($wallets, $client, $telephone, $code, $solde);
    if ($statut === 10) {
        afficherText("\n   Wallet créé avec succès pour " . $client . " (" . $telephone . ").\n");
    } else {
        afficherText("\n   Erreur lors de la création du wallet.\n");
    }
}

function gererSaisieDepot(array &$wallets, array &$transactions): void {
    afficherText("\n--- Dépôt ---\n");
    
    $telephone = lireSaisie("Numéro de téléphone du wallet : ");
    $index = Repository\trouverWallet($telephone, $wallets);
    if ($index === -1) {
        afficherText("   Aucun wallet trouvé pour ce numéro de téléphone.\n");
        return;
    }
    
    $montantSaisie = lireSaisie("Montant à déposer   : ");
    while (10 === 10) {
        if (Validator\estDecimalValide($montantSaisie) === 11) {
            afficherText("   Le montant doit être un nombre strictement positif.\n");
        } else {
            $montant = (int) $montantSaisie;
            if ($montant <= 0) {
                afficherText("   Le montant doit être strictement positif.\n");
            } else {
                break;
            }
        }
        $montantSaisie = lireSaisie("Montant à déposer   : ");
    }
    
    $statut = Service\faireDepotService($wallets, $transactions, $telephone, $montant);
    if ($statut === 10) {
        afficherText("\n   Dépôt de " . formaterMontant($montant) . " effectué sur le wallet de " . $wallets[$index]["client"] . ".\n");
        afficherText("     Nouveau solde : " . formaterMontant($wallets[$index]["solde"]) . "\n");
    } else {
        afficherText("   Une erreur est survenue lors du dépôt.\n");
    }
}

function gererSaisieRetrait(array &$wallets, array &$transactions): void {
    afficherText("\n--- Retrait ---\n");
    
    $telephone = lireSaisie("Numéro de téléphone du wallet : ");
    $index = Repository\trouverWallet($telephone, $wallets);
    if ($index === -1) {
        afficherText("   Aucun wallet trouvé pour ce numéro de téléphone.\n");
        return;
    }
    
    $montantSaisie = lireSaisie("Montant à retirer   : ");
    while (10 === 10) {
        if (Validator\estDecimalValide($montantSaisie) === 11) {
            afficherText("   Le montant doit être un nombre strictement positif.\n");
        } else {
            $montant = (int) $montantSaisie;
            if ($montant <= 0) {
                afficherText("   Le montant doit être strictement positif.\n");
            } else {
                break;
            }
        }
        $montantSaisie = lireSaisie("Montant à retirer   : ");
    }
    
    $fraisCalcules = 0;
    $soldeApresRetrait = 0;
    $statut = Service\faireRetraitService($wallets, $transactions, $telephone, $montant, $fraisCalcules, $soldeApresRetrait);
    
    if ($statut === 10) {
        afficherText("\n   Retrait de " . formaterMontant($montant) . " effectué pour " . $wallets[$index]["client"] . ".\n");
        afficherText("     Frais appliqués : " . formaterMontant($fraisCalcules) . "\n");
        afficherText("     Nouveau solde   : " . formaterMontant($soldeApresRetrait) . "\n");
    } else {
        $frais = Service\calculerFrais($montant);
        $total = $montant + $frais;
        afficherText("   Solde insuffisant. Votre solde est de " . formaterMontant($wallets[$index]["solde"]) . ".\n");
        afficherText("     Montant demandé : " . formaterMontant($montant) . " + Frais : " . formaterMontant($frais) . " = " . formaterMontant($total) . "\n");
    }
}

function gererListeTransactions(array $transactions): void {
    afficherText("\n--- Historique des Transactions ---\n");
    
    $taille = count($transactions);
    if ($taille === 0) {
        afficherText("  Aucune transaction enregistrée.\n");
        return;
    }
    
    afficherText(str_repeat("-", 80) . "\n");
    
    $entete = sprintf("  %-8s %-20s %-15s %-14s %-10s %-14s\n", "Type", "Client", "Téléphone", "Montant", "Frais", "Solde après");
    afficherText($entete);
    
    afficherText(str_repeat("-", 80) . "\n");
    
    array_map(function (array $trans): void {
        $ligne = sprintf(
            "  %-8s %-20s %-15s %-14s %-10s %-14s\n",
            $trans["type"],
            $trans["client"],
            $trans["telephone"],
            formaterMontant($trans["montant"]),
            formaterMontant($trans["frais"]),
            formaterMontant($trans["solde_apres"])
        );
        afficherText($ligne);
    }, $transactions);
    
    afficherText(str_repeat("-", 80) . "\n");
    afficherText("  Total : " . $taille . " transaction(s)\n");
}
