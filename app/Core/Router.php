<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function addRoutes(array $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    public function initRouter(): void
    {
        $directory = new \RecursiveDirectoryIterator(DIR_ROOT . '/Controllers');
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach ($files as $file) {
            $file = $file[0];
            // /app/Controllers/HomeController.php //! ON A CA
            // App\Controllers\HomeController.php //! ET ON VEUT CA

            //TODO On enlève le / du début
            $file = substr($file, 1);

            // TODO On remplace les / par des \
            $file = str_replace('/', '\\', $file);

            // TODO Supprimer l'extension php
            $file = substr($file, 0, -4);

            //TODO Mettre le A en majuscule
            $file = ucfirst($file);

            // var_dump(value: $file);

            //! FQCN : Full Qualify Class Name

            if (class_exists($file)) {
                $classes[] = $file;

                // var_dump($classes);
            }
        }

        foreach ($classes as $class) {
            $methods = get_class_methods($class);

            foreach ($methods as $method) {
                $attributes = (new \ReflectionMethod($class, $method))->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $route->setController($class);
                    $route->setAction($method);

                    $this->addRoutes([
                        'url' => $route->getUrl(),
                        'methods' => $route->getMethods(),
                        'controller' => $route->getController(),
                        'action' => $route->getAction(),
                        'name' => $route->getName(),
                    ]);



                }
            }
        }

        $_SESSION['routes'] = $this->routes;
    }

    public function handleRequest(string $url, string $method): void
    {
        // On vérifie si l'url du navigateur commence par /admin

        if (preg_match("~^/admin~", $url)) {
            // on vérifie si l'utilisateur n'est pas connecté et qu'il n'a pas le rôle ADMIN
            if (empty($_SESSION['USER']) || !in_array('ROLE_ADMIN', $_SESSION['USER']['roles'])) {
                $_SESSION['flash']['danger'] = "Vous n'avez pas accès à cette zone, veuillez-vous connecter avec un compte Admin";
                // On redirige vers la page de connexion
                $response = new Response('', 403, ['Location' => '/login']); // 403 >> forbidden
                $response->send();

                return;
            }
        }


        // On boucle sur toutes les routes de notre application
        foreach ($this->routes as $route) {


            // On vérifie si l'URL du navigateur correspond à une url dans notre routeur et si la méthode HTTP du navigateur correspond aux méthodes autorisées de la route
            if (preg_match('#^' . $route['url'] . '$#', $url, $matches) && in_array($method, $route['methods'])) {
                // On appel le controller 
                $controllerName = $route['controller'];
                // On instancie le controller de la route
                $controller = new $controllerName();
                // On execute la méthode de la route
                $actionName = $route['action'];

                $params = array_slice($matches, 1);    // on enleve le premier car il ne nous sert pas trop ici (ici on a pas besoin de l'url)

                $response = $controller->$actionName(...$params);  // ! On veut extirper chaque élément du tableau et on va le passer comme paramètres

                $response->send();

                return;
            }
        }

        // Si aucune route n'a pu prendre en charge la demande, on redirige l'utilisateur vers la page 404
        http_response_code(404);
        echo '404 - Page not found';
        exit(404);

    }

    public function getUrl(string $name): ?string
    {
        foreach ($_SESSION['routes'] ?? [] as $route) {
            if ($route['name'] === $name) {
                return $route['url'];
            }
        }

        return null;
    }
}