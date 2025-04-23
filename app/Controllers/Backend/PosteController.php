<?php

namespace App\Controllers\Backend;

use create;
use App\Core\Route;
use App\Models\Poste;
use App\Core\Response;
use App\Form\PosteForm;
use App\Core\AbstractController;

class PosteController extends AbstractController
{
    #[Route('admin.poste.index', '/admin/postes', ['GET'])]
    public function index(): Response
    {
        $postes = (new Poste)->findAll();

        return $this->render('backend/poste/index.php', ['postes' => $postes]);
    }

    #[Route('admin.poste.create', '/admin/postes/create', ['GET', 'POST'])]
    public function create(): Response
    {
        // On instancie le formulaire
        $form = new PosteForm(); // on va chercher le fichier PosteForm.php dans le dossier Form

        // On verifie si le formulaire a été soumis et si les données sont validées
        if ($form->validate(['title', 'description'], $_POST)) {
            // On récupère et on nettoie les données du formulaire
            $title = strip_tags(trim($_POST['title']));
            $description = strip_tags(trim($_POST['description']));
            $enabled = isset($_POST['enabled']) ? true : false; // si il y a une checkbox checked, on met true, sinon on met false

            (new Poste)
                ->setTitle($title)
                ->setDescription($description)
                ->setEnabled($enabled)
                ->create();

            // On redirige vers la page d'accueil avec un message de succès
            $this->addFlash('success', 'Le poste a bien été créé');
            return $this->redirectToRoute('admin.poste.index');
        }

        return $this->render('backend/poste/create.php', ['form' => $form->createForm()]);
    }



}