<?php

namespace App\Core;

abstract class AbstractController
{
    protected function render(string $view, array $data = []): void // pk protected ? > on veut qu'elle soit héritée dans les classes filles
    {
        // Extraire les données pour les rendre accessibles dans la vue

        // var_dump($poste); //TODO ne marche pas : Warning: Undefined variable $poste in /app/Core/AbstractController.php on line 11

        extract($data); // le extract va prendre le tableau, va extraire la clé et la valeur et va les mettre dans des variables 

        // var_dump($poste);

        // var_dump($data, $view);
        require DIR_ROOT . '/Views/' . $view;
    }
}
