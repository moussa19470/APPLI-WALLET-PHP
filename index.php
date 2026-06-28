<?php

require_once "controller.php";
require_once "services.php";
require_once "repository.php";
require_once "validator.php";

do {

    echo "\n";
    echo "** Menu Distributeur **\n";
    echo "1 - Creer Wallet\n";
    echo "2 - Faire Depot\n";
    echo "3 - Faire Retrait\n";
    echo "4 - Lister les Transactions\n";
    echo "0 - Quitter\n";

    $choix = readline("Votre choix : ");

    switch ($choix) {

        case "1":
            echo "Fonctionnalite Creer Wallet a venir\n";
            break;

        case "2":
            echo "Fonctionnalite Depot a venir\n";
            break;

        case "3":
            echo "Fonctionnalite Retrait a venir\n";
            break;

        case "4":
            echo "Fonctionnalite Transactions a venir\n";
            break;

        case "0":
            echo "Au revoir\n";
            break;

        default:
            echo "Choix invalide, veuillez reessayer\n";
    }

} while ($choix != "0");