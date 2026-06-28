<?php

use function App\Controller\ajouterWallet;
use function App\Controller\faireUnDepot;
use function App\Controller\faireUnRetrait;
use function App\Controller\afficheListeTransaction;

require_once __DIR__ . '/vendor/autoload.php';

// Tableau numerique de wallets
$wallets = [
    0 => ['client' => 'Moussa BA', 'telephone' => '775788482', 'codeSecret' => '1234', 'solde' => 0],
    1 => ['client' => 'Mr WANE', 'telephone' => '785763489', 'codeSecret' => '1010', 'solde' => 3000]
];
$transactions = [
    0 => ['montant' => +5000, 'frais' => 0, 'indexClient' => 0],
    1 => ['montant' => -2000, 'frais' => 200, 'indexClient' => 1],
    2 => ['montant' => -3000, 'frais' => 200, 'indexClient' => 0]
];
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
            faireUnRetrait();
            break;
        case 4:
            afficheListeTransaction($transactions, $wallets);
            break;
        case 0:
            break;
        default:
            echo "Choix invalide, veuillez reessayer\n";
            break;
    }
} while ($choix != 0);