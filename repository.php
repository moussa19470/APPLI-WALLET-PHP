<?php

// Cherche l'index d'un wallet a partir du telephone, -1 si non trouve
function existTelephone(string $telephone, array $wallets): int {
    foreach ($wallets as $index => $wallet) {
        if ($wallet['telephone'] == $telephone) {
            return $index;
        }
    }
    return -1;
}

function ajouterMontantAuSolde(int $index, int $montant): void {
    global $wallets;
    $wallets[$index]['solde'] += $montant;
}

// Enregistre une transaction. $frais est optionnel, utile pour tracer
// les frais de retrait dans l'historique (defaut 0 pour un depot).
function enregistrerUneTransaction(int $index, int $montant, float $frais = 0): void {
    global $transactions;
    $transaction = ['montant' => $montant, 'frais' => $frais, 'indexClient' => $index];
    $transactions[] = $transaction;
}