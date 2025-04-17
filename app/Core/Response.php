<?php

namespace App\Core;

class Response
{
    //TODO  notre objet response va stocker 3 éléments : le contenu de la réponse, le statut HTTP, des entêtes personnalisées si besoin
    public function __construct(
        private string $content = "", // tout le contenu de la réponse du navigateur sera en html en string
        private int $status = 200,
        private array $headers = [],
    ) {

    }

    // Maintenant, il faut simplement créer une méthode dans la classe Response pour envoyer la reponse
    public function send(): void
    {
        http_response_code($this->status); // ça envoie un code http au navigateur > fonction native au php 

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
            // header("Location : /login"); > on peut charger n'importe quel loader pour n'importe quelle réponse
        }

        echo $this->content;
    }
 
}