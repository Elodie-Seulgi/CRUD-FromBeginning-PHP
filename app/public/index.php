<?php
use App\Autoloader;

use App\Core\App;

// use App\Models\User;
// use App\Models\Poste;

// use App\Db\Database;

// TODO On va vouloir définir une constante qui va stocker le chemin absolu du dossier racine/parent

define('DIR_ROOT', dirname(__DIR__));

// var_dump(value: DIR_ROOT);

require_once '/app/Autoloader.php';

Autoloader::register();

//TODO : On va instancier l'objet App (qui représente notre application)

$app = new App();

// TODO On va lancer l'application
$app->start();

//$db = new Database();

// $db = Database::getInstance();

//TODO : FIND ALL
// $postes = (new Poste())->findAll();

//TODO : FIND BY
// $postes = (new Poste())
//     ->findBy([
//         'enabled' => true,
//     ]);

//TODO : FIND
// $postes = (new Poste())
//     ->find(1);
// ;


//TODO : Version plus développée
// $poste = new Poste();

// $poste
//     ->setTitle('Développeur Symfony')
//     ->setDescription('Développeur Symfony H/F')
//     ->setEnabled(true);

//TODO : Version abrégée
// $poste = (new Poste())
//     ->setTitle('Développeur Symfony')
//     ->setDescription('Développeur Symfony H/F')
//     ->setEnabled(true)
//     ->setCreatedAt(new \DateTime())
//     ->create();

// $donnees = [
//     'title' => 'Mon titre',
//     'description' => 'Ma description',
//     'enabled' => true,
//     'createdAt' => '2024-01-01 15:12:00',
// ];

// $poste = (new Poste())
//     ->hydrate($donnees)
//     ->create();

// var_dump($poste);

// $poste = (new Poste())
//     ->find(6);

// var_dump($poste);

// $poste = (new Poste())
//     ->hydrate($poste);

// $poste
//     ->setTitle('Développeur Vue JS modifié')
//     ->update();

// $poste->delete();

// $poste = (new Poste())->find(1);

// ! si User est souligné : clic droit import class

// $user = (new User())
//     ->setFirstName('Elodie')
//     ->setLastName('WIART')
//     ->setEmail('elowia@example.com')
//     ->setPassword(
//         password_hash('azerty', PASSWORD_ARGON2I)
//     )
//     ->setRoles(['ROLE_ADMIN'])
//     ->create();

// var_dump($user);

