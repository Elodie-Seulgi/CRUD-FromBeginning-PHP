<?php

namespace App\Controllers\Security;

use App\Core\Route;
use App\Models\User;
use App\Core\Response;
use App\Form\LoginForm;
use App\Core\AbstractController;

class SecurityController extends AbstractController
{
    #[Route('app.security.login', '/login', ['POST', 'GET'])] // Deux méthodes GET et POST car si on n'avait que POST, on ne pourrait pas afficher le formulaire pour la première fois
    public function login(): Response
    {
        // (new User)
        // ->setFirstName('Elodie')
        // ->setLastName('WIART')
        // ->setEmail('ew@example.com')
        // ->setPassword(password_hash('ew', PASSWORD_ARGON2I))
        // ->setRoles(['ROLE_ADMIN'])
        // ->create();


        // On instancie le formulaire
        $form = new LoginForm(); // on va chercher le fichier LoginForm.php dans le dossier Form

        if ($form->validate(['email', 'password'], $_POST)) {
            // On récupère et on nettoie les données du formulaire
            $email = strip_tags($_POST['email']);
            $password = $_POST['password'];

            $user = (new User)->findOneByEmail($email);

            if (!$user || !password_verify($password, $user->getPassword())) {
                // Afficher un message flash
                $this->addFlash('danger', 'Identifiants incorrects');

                // TODO On redirige vers la page de connexion
                return $this->redirectToRoute('app.security.login');
            }

            // Connecter l'utilisateur
            $user->connectUser();

            // Ajouter un message de succès
            $this->addFlash('success', 'Vous êtes bien connecté');

            // TODO Rediriger vers la page d'accueil
            return $this->redirectToRoute('app.home');
        }

        return $this->render('security/login.php', [
            'form' => $form->createForm(),
        ]);
    }

    #[Route('app.security.logout', '/logout', ['GET'])]
    public function logout(): Response
    {
        // Déconnecter l'utilisateur
        unset($_SESSION['USER']);

        // TODO Rediriger vers la page d'accueil
        return $this->redirectToRoute('app.home');

    }
}