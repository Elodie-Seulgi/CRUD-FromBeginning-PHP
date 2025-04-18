<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\Response;
use App\Core\Route;

class HomeController extends AbstractController
{
    #[Route('app.home', '/', ['GET'])] // convention de nommage app.home, admin.home etc ...
    public function index(): Response
    {
        // // echo "page d'accueil";
        // //! Pour rendre une vue, on fait : 
        // require DIR_ROOT . '/Views/home/index.php';

        return $this->render('home/index.php');
    }

}