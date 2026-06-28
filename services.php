<?php

require_once 'validator.php';

function creerWallet(array $wallet, array $wallets): array {
    if (estVideWallet($wallet) &&
        estUniqueDansSystem($wallets, $wallet) &&
        estValideFormatTelephone($wallet) &&
        estPositifSolde($wallet) &&
        estValideCodeSecret($wallet) &&
        estValideLongueurTelephone($wallet)
    ) {
        return $wallet;
    }
    return [];
}

function calculFrais(float $montant): float {
    if ($montant <= 10000) {
        return 200;
    }

    if ($montant <= 100000) {
        return 500;
    }

    $frais = 0.01 * $montant;
    if ($frais >= 5000) {
        return 5000;
    }
    return $frais;
}