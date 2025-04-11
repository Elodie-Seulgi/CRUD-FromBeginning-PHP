<?php

namespace App\Models;

use App\Core\Database;

/**
 * @property-read int $id
 */

abstract class Model extends Database
{
    protected ?string $table = null;
    protected ?Database $db = null;

    public function findAll(): array
    {
        $pdoStatement = $this
            ->runQuery("SELECT * FROM $this->table")
            ->fetchAll();

        return $this->fetchHydrate($pdoStatement);
    }


    public function findBy(array $filters): array
    {
        // On crée un tableau vide qui va stocker les champs avec les markers SQL
        $champs = [];
        // On crée un tableau vide qui va stocker les valeurs (tableau associatif execute)
        $params = [];

        //On boucle sur le tableau qui stocke les filtres
        foreach ($filters as $champ => $valeur) { // ici cela prendra donc $champ = id, $valeur = 1 par exemple
            // on ajoute le champ avec le marker SQL
            $champs[] = "$champ = :$champ";
            // On ajoute la valeur au tableau associatif
            $params[":$champ"] = $valeur;

        }

        // on transforme le tableau champs en une seule chaîne de caractères avec des ' AND ' entre chaque champ
        $listeChamps = implode(' AND ', $champs);

        // On execute la requete

        $pdoStatement = $this
            ->runQuery(
                "SELECT * FROM $this->table WHERE $listeChamps",
                $params
            )
            ->fetchAll();

        return $this->fetchHydrate($pdoStatement);
    }

    public function find(int $id): bool|object
    {
        $pdoStatement = $this
            ->runQuery(
                "SELECT * FROM $this->table WHERE id = :id",
                [":id" => $id]
            )->fetch();

        return $this->fetchHydrate($pdoStatement);

    }

    //TODO CREATE

    public function create(): ?\PDOStatement
    {
        // INSERT INTO postes (title, description, enabled) VALUES (:title, :description, :enabled)

        $champs = [];
        $markers = [];
        $params = [];

        foreach ($this as $champ => $valeur) {
            if ($champ === 'db' || $champ === 'table' || $valeur === null) {
                continue;
            }

            $champs[] = $champ;
            $markers[] = ":$champ";

            //TODO : On gère les contextes particuliers entre PHP et MySQL
            if (gettype($valeur) === 'boolean') {
                $valeur = (int) $valeur; // booléen va être transformé en int >> conversion va se faire automatiquement, PHP comprend que false est 0 et true est 1.
            } else if (gettype($valeur) === 'array') {
                $valeur = json_encode($valeur);
            } else if ($valeur instanceof \DateTime) { // instance > est ce que c'est un objet de la classe DateTime
                $valeur = $valeur->format('Y-m-d H:i:s');
            }
            $params[$champ] = $valeur;
        }

        $listeChamps = implode(', ', $champs);
        $listeMarkers = implode(', ', $markers);

        return $this
            ->runQuery(
                "INSERT INTO $this->table ($listeChamps) VALUES ($listeMarkers)",
                $params
            );

    }

    //TODO PUBLIC FUNCTION UPDATE

    public function update(): ?\PDOStatement
    {
        // UPDATE postes SET title = :title, description = :description, enabled = :enabled WHERE id = :id

        $champs = [];
        $params = [];

        foreach ($this as $champ => $valeur) {
            if ($champ === 'db' || $champ === 'table' || $valeur === null || $champ === 'id') {
                continue; //passe au suivant si les conditions sont remplies
            }

            $champs[] = "$champ = :$champ";

            //TODO : On gère les contextes particuliers entre PHP et MySQL
            if (gettype($valeur) === 'boolean') {
                $valeur = (int) $valeur; // booléen va être transformé en int >> conversion va se faire automatiquement, PHP comprend que false est 0 et true est 1.
            } else if (gettype($valeur) === 'array') {
                $valeur = json_encode($valeur);
            } else if ($valeur instanceof \DateTime) { // instance > est ce que c'est un objet de la classe DateTime
                $valeur = $valeur->format('Y-m-d H:i:s');
            }
            $params[$champ] = $valeur;
        }

        $listeChamps = implode(', ', $champs);

        $params[':id'] = $this->id;

        return $this
            ->runQuery(
                "UPDATE $this->table SET $listeChamps WHERE id = :id",
                $params
            );
    }

    //TODO : PUBLIC FUNCTION DELETE 


    public function delete(): ?\PDOStatement
    {
        // DELETE FROM postes WHERE id = :id

        return $this
            ->runQuery(
                "DELETE FROM $this->table WHERE id = :id",
                [

                    ":id" => $this->id,
                ]
            );
    }

    //TODO : PUBLIC FUNCTION HYDRATE

    public function hydrate(array|object $data): static // self et on inclue aussi les classes enfant
    {
        //On boucle sur le tableau
        foreach ($data as $key => $valeur) {
            $method = 'set' . ucfirst($key); //premiere lettre en majuscule UC first
            if (method_exists($this, $method)) {
                // On vérifie si c'est le champ createdAt = création d'un objet Datetime
                if ($key === 'createdAt') {
                    $valeur = new \DateTime($valeur);
                }

                // On execute la methode
                $this->$method($valeur);
            }
        }
        return $this;
    }

    //TODO : PUBLIC FUNCTION HYDRATE FETCH

    public function fetchHydrate(mixed $query): array|static|bool
    {
        // On boucle sur le tableau
        // var_dump($query);

        if (is_array($query) && count($query) > 0) {
            //Boucle sur le tableau de résultats pour instancier chaque objet

            // ! Méthode array_map
            return array_map(
                function ($object): static {
                    return (new static())->hydrate($object);
                },
                $query // le array map va boucler sur le tableau query et pour chaque élément du tableau, il va faire un hydrate
            );
            //! Fin de la Méthode array_map

            // TODO Version plus courte array_map
            // return array_map(
            //     fn ($object) => (new static())->hydrate($object),
            //     $query
            // );
            // TODO Fin de la version plus courte

            // $data = [];

            // foreach ($query as $object) {
            //     $data[] = (new static())->hydrate($object);
            // }

            // return $data;


        } else if (is_object($query)) {
            // On a un objet standard dans $query -> on instancie un objet de la classe et on hydrate
            return (new static())->hydrate($query);
        } else {
            return $query;
        }
    }

    //Requête simple -> SELECT * FROM TABLE
    //Requête préparée -> SELECT * FROM TABLE WHERE id = :id

    // Quel est l'objectif de la requête ?
    protected function runQuery(string $sql, ?array $params = null): ?\PDOStatement // soit null soit PDO statement
    {
        // On récupère la connexion en BDD
        $this->db = Database::getInstance();
        // On vérifie (IF) si la requête est préparée ou non 
        if ($params !== null) {
            // La requête est préparée
            $query = $this->db->prepare($sql);
            // On execute la requête
            $query->execute($params);
            // On retourne la requête
            return $query;
        } else {
            return $this->db->query($sql);
        }
    }


}