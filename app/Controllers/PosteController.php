<?php

namespace App\Controllers;

use App\Core\Route;
use App\Models\Poste;

class PosteController
{
    #[Route('app.poste.show', '/poste/details/([0-9]+)', ['GET'])] // convention de nommage app.home, admin.home etc ...[Route('app.poste.show', '/poste/details/{id}', ['GET'])]
    public function show(int $id): void
    {
        $poste = (new Poste())->find($id);

        var_dump($poste);
    }
}