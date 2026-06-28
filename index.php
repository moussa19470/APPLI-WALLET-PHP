<?php

require_once 'controller.php';

$wallets = [
    0 => ['client' => 'Moussa BA', 'telephone' => '775788482', 'codeSecret' => '1234', 'solde' => 0],
    1 => ['client' => 'Mr WANE', 'telephone' => '785763489', 'codeSecret' => '1010', 'solde' => 3000]
];

$transactions = [];

function afficheMenu(): void {
    echo "---Menu Distributeur---\n";
    echo "1. Creer Wallet \n";
    echo "2. Faire Depot \n";
    echo "3. Faire Retrait \n";
    echo "4. Lister les Transactions \n";
    echo "0. Quitter \n";
    echo "-----------------------\n";
}

function lireChoix(): int {
    return (int) readline("Entrez votre choix : \n");
}

do {
    afficheMenu();
    $choix = lireChoix();

    switch ($choix) {
        case 1:
            ajouterWallet();
            break;
       case 2:
            faireUnDepot();
            break;
        case 3:
            echo "Fonctionnalite Retrait a venir\n";
            break;
        case 4:
            echo "Fonctionnalite Transactions a venir\n";
            break;
        case 0:
            break;
        default:
            echo "Choix invalide, veuillez reessayer\n";
            break;
    }
} while ($choix != 0);