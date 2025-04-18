<?php

namespace App\Core;

class App
{
    public function __construct(
        private Router $router = new Router(),
    ) {

    }

    /**
     * Démarre l'application
     *
     * @return void
     */
    public function start(): void
    {
        session_start();

        // On stocke l'URL du navigateur dans une variable
        $url = $_SERVER['REQUEST_URI'];

        // on va vérifier si l'url n'est pas juste / et si elle termine par un / 
        if (!empty($url) && $url !== '/' && $url[-1] === '/') {
            $url = substr($url, 0, -1); // on va supprimer le dernier / de notre url

            // On redirige vers l'url
            // redirection permanent 301, redirection temporaire 302
            http_response_code(301);

            header("Location: $url");
            exit(301);
        }

        // TODO Init du routeur
        $this->router->initRouter();

        // On appel le routeur et on lui passe l'url et la methode HTTP du navigateur
        $this->router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

    }


}
