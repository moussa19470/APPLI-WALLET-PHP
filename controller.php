<?php

namespace App\Controller;

use function App\Services\creerWallet;
use function App\Services\calculFrais;
use function App\Repository\existTelephone;
use function App\Repository\ajouterMontantAuSolde;
use function App\Repository\miseAjourSolde;
use function App\Repository\enregistrerUneTransaction;
use function App\Validator\estVideWallet;
use function App\Validator\estPositifSolde;
use function App\Validator\estValideLongueurTelephone;
use function App\Validator\estValideFormatTelephone;
use function App\Validator\estValideCodeSecret;
use function App\Validator\estUniqueDansSystem;
use function App\Validator\montantPositif;
use function App\Validator\estDebitableSolde;

require_once 'services.php';
require_once 'repository.php';

function afficheMessage(string $message): void {
    echo "Message : {$message}\n";
}

function afficheListeTransaction(array $transactions, array $wallets): void {
    foreach ($transactions as $transaction) {
        echo "Montant : {$transaction['montant']}\n";
        $indexClient = $transaction['indexClient'];
        $client = $wallets[$indexClient];
        echo "Titulaire : {$client['client']}\n";
    }
}

function afficheListeTransactionParTelephone(array $transactions, array $wallets): void {
    $telephone = saisirTelephone();
    $index = existTelephone($telephone, $wallets);

    if ($index == -1) {
        afficheMessage("Telephone introuvable");
        return;
    }

    $transactionsDuClient = array_filter($transactions, fn($transaction) =>
        $transaction['indexClient'] == $index
    );

    foreach ($transactionsDuClient as $transaction) {
        echo "Montant : {$transaction['montant']}\n";
    }
}

function saisirWallet(): array {
    $wallet = ['client' => '', 'telephone' => '', 'codeSecret' => '', 'solde' => 0];
    $wallet['client'] = readline("Entrez le nom du client : ");
    $wallet['telephone'] = readline("Entrez le numero de telephone : ");
    $wallet['codeSecret'] = readline("Entrez le code secret : ");
    $wallet['solde'] = (int) readline("Entrez le montant du solde : ");
    return $wallet;
}

function saisirTelephone(): string {
    return readline("Entrez le numero de telephone : ");
}

function saisirMontant(): int {
    return (int) readline("Entrez le montant : ");
}

function ajouterWallet(): void {
    global $wallets;

    $wallet = saisirWallet();

    if (!estVideWallet($wallet)) {
        afficheMessage("Le nom, le telephone et le code secret sont obligatoires");
        return;
    }
    if (!estPositifSolde($wallet)) {
        afficheMessage("Le solde initial doit etre positif ou nul");
        return;
    }
    if (!estValideLongueurTelephone($wallet)) {
        afficheMessage("Le numero de telephone doit contenir 9 chiffres");
        return;
    }
    if (!estValideFormatTelephone($wallet)) {
        afficheMessage("Le format du numero de telephone est invalide");
        return;
    }
    if (!estValideCodeSecret($wallet)) {
        afficheMessage("Le code secret doit contenir 4 chiffres");
        return;
    }
    if (!estUniqueDansSystem($wallets, $wallet)) {
        afficheMessage("Ce telephone ou ce code secret est deja utilise");
        return;
    }

    $newWallet = creerWallet($wallet, $wallets);
    $wallets[] = $newWallet;
    afficheMessage("Wallet cree avec succes");
}

function faireUnDepot(): void {
    global $wallets, $transactions;

    $telephone = saisirTelephone();
    $index = existTelephone($telephone, $wallets);

    if ($index == -1) {
        afficheMessage("Telephone introuvable");
        return;
    }

    $montant = saisirMontant();

    if (!montantPositif($montant)) {
        afficheMessage("Le montant doit etre strictement positif");
        return;
    }

    ajouterMontantAuSolde($index, $montant);
    enregistrerUneTransaction($index, $montant);

    afficheMessage("Depot effectue avec succes");
}

function faireUnRetrait(): void {
    global $wallets, $transactions;

    $telephone = saisirTelephone();
    $index = existTelephone($telephone, $wallets);

    if ($index == -1) {
        afficheMessage("Telephone introuvable");
        return;
    }

    $montant = saisirMontant();

    if (!montantPositif($montant)) {
        afficheMessage("Le montant doit etre strictement positif");
        return;
    }

    $frais = calculFrais($montant);

    if (!estDebitableSolde($index, $montant, $frais, $wallets)) {
        afficheMessage("Solde insuffisant pour couvrir le montant et les frais ({$frais} CFA)");
        return;
    }

    $montantNegatif = -1 * $montant;

    miseAjourSolde($index, $montant, $frais);
    enregistrerUneTransaction($index, $montantNegatif, $frais);

    afficheMessage("Retrait effectue avec succes, frais appliques : {$frais} CFA");
}
