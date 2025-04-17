<?php

namespace App\Controllers;

use App\Core\Route;
use App\Models\Poste;
use App\Core\AbstractController;

class PosteController extends AbstractController
{
    #[Route('app.poste.show', '/poste/details/([0-9]+)', ['GET'])] // convention de nommage app.home, admin.home etc ...[Route('app.poste.show', '/poste/details/{id}', ['GET'])]
    public function show(int $id): void
    {
        $poste = (new Poste())->find($id);

        // var_dump($poste);

        // require DIR_ROOT . '/Views/postes/show.php'; // TODO  cette méthode n'est pas très propre dans l'écriture, on va mieux la manipuler avec la méthode render

        $this->render('postes/show.php', ['poste' => $poste]); // on va mettre data > une clé et une valeur 
    }
}