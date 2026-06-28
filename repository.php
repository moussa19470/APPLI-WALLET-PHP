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