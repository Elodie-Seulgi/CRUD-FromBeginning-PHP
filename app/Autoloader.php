<?php

namespace App;

/**
 * Class Autoloader pour chargement dynamique de fichier
 */
class Autoloader
{
    static function register(): void
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    static function autoload(string $class): void
    {
        // On retire App\
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);

        // On replace les \ par des /
        $class = str_replace('\\', '/', $class);

        // Récupérer le fichier
        $fichier = __DIR__ . '/' . $class . '.php';

        // On vérifie si le fichier existe
        if (file_exists($fichier)) {
            // On inclue  du fichier
            require_once($fichier);
        }
    }
}
