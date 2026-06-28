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