<?php

namespace App\Controllers\Backend;

use App\Core\Route;
use App\Models\Poste;
use App\Core\Response;
use App\Core\AbstractController;

class PosteController extends AbstractController
{
    #[Route('admin.poste.index', '/admin/postes', ['GET'])]
    public function index(): Response
    {
        $postes = (new Poste)->findAll();

        return $this->render('backend/poste/index.php', ['postes' => $postes]);
    }
}

