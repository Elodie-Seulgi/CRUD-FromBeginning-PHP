<?php

namespace App\Core;

use PDO;
use PDOException;

class Database extends PDO
{
    private static ?self $instance = null; // self fait référence à la classe en cours donc Database
    private const DB_HOST = 'mvclyon2025-phporientobjet-db-1';
    private const DB_NAME = 'mvc_cours';
    private const DB_USER = 'root';
    private const DB_PASSWORD = 'root';

    public function __construct()
    {
        $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8mb4';
        try {
            parent::__construct(
                $dsn, // on fait référence à la classe étendue PDO
                self::DB_USER,
                self::DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    // PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}