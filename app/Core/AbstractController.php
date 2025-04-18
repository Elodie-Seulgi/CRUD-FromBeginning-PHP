<?php

namespace App\Core;


abstract class AbstractController
{
    protected function render(string $view, array $data = []): Response // pk protected ? > on veut qu'elle soit héritée dans les classes filles
    {
        // Extraire les données pour les rendre accessibles dans la vue

        // var_dump($poste); //TODO ne marche pas : Warning: Undefined variable $poste in /app/Core/AbstractController.php on line 11

        extract($data); // le extract va prendre le tableau, va extraire la clé et la valeur et va les mettre dans des variables 

        // var_dump($poste);

        // var_dump($data, $view);

        // Rendre la vue
        // Démarrer le buffer de sortie pour mettre en mémoire le contenu sans l'afficher
        ob_start();

        // Inclure le fichier de la vue
        require DIR_ROOT . '/Views/' . $view;

        $content = ob_get_clean(); // on stocke le contenu du buffer dans une variable

        // On redémarre le buffer de sortie
        ob_start();

        // Rendre le template de base
        require DIR_ROOT . '/Views/base.php';

        // On stock le contenu du buffer dans une variable
        $finaleContent = ob_get_clean();

        return new Response(
            $finaleContent,
            200,
        );
    }

    protected function addFlash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;

    }

    protected function redirectToRoute(string $name): Response
    {
        $url = (new Router)->getUrl($name);

        return new Response('', 302, ['Location' => $url]);
    }
}

