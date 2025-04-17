<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\Route;

class HomeController extends AbstractController
{
    #[Route('app.home', '/', ['GET'])] // convention de nommage app.home, admin.home etc ...
    public function index(): void
    {
        // echo "page d'accueil";
        //! Pour rendre une vue, on fait : 
        require DIR_ROOT . '/Views/home/index.php';
    }

    #[Route('app.test', '/test', ['GET'])]
    public function test(): void
    {
        echo "Page de test";
    }

    #[Route('app.login', '/login', ['GET'])]
    public function login(): void
    {
        echo "Page de login";
    }
}