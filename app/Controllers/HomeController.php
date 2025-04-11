<?php

namespace App\Controllers;

use App\Core\Route;

class HomeController
{
    #[Route('app.home', '/', ['GET'])] // convention de nommage app.home, admin.home etc ...
    public function index(): void
    {
        echo "page d'accueil";
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