<?php

require_once 'services.php';
require_once 'repository.php';

function afficheMessage(string $message): void {
    echo "Message : {$message}\n";
}

function saisirWallet(): array {
    $wallet = ['client' => '', 'telephone' => '', 'codeSecret' => '', 'solde' => 0];
    $wallet['client'] = readline("Entrez le nom du client : ");
    $wallet['telephone'] = readline("Entrez le numero de telephone : ");
    $wallet['codeSecret'] = readline("Entrez le code secret : ");
    $wallet['solde'] = (int) readline("Entrez le montant du solde : ");
    return $wallet;
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

function saisirTelephone(): string {
    return readline("Entrez le numero de telephone : ");
}

function saisirMontant(): int {
    return (int) readline("Entrez le montant : ");
}

// RG 2.1 : depot
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