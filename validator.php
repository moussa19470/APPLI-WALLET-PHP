<?php

function estVideWallet(array $wallet): bool {
    if ($wallet['client'] == '' ||
        $wallet['telephone'] == '' ||
        $wallet['codeSecret'] == '') {
        return false;
    }
    return true;
}

function estPositifSolde(array $wallet): bool {
    if ($wallet['solde'] < 0) {
        return false;
    }
    return true;
}

function estUniqueDansSystem(array $wallets, array $wallet): bool {
    foreach ($wallets as $index => $element) {
        if ($element['telephone'] == $wallet['telephone'] ||
            $element['codeSecret'] == $wallet['codeSecret']) {
            return false;
        }
    }
    return true;
}

function estValideFormatTelephone(array $wallet): bool {
    if (substr($wallet['telephone'], 0, 2) != '77' &&
        substr($wallet['telephone'], 0, 2) != '78' &&
        substr($wallet['telephone'], 0, 2) != '75' &&
        substr($wallet['telephone'], 0, 2) != '76' &&
        substr($wallet['telephone'], 0, 2) != '70'
    ) {
        return false;
    }
    return true;
}

function estValideLongueurTelephone(array $wallet): bool {
    if (strlen($wallet['telephone']) != 9) {
        return false;
    }
    return true;
}

function estValideCodeSecret(array $wallet): bool {
    if (strlen($wallet['codeSecret']) != 4) {
        return false;
    }
    return true;
}

function montantPositif(int $montant): bool {
    if ($montant <= 0) {
        return false;
    }
    return true;
}