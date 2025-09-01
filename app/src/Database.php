<?php
require_once __DIR__ . '/Config.php';


class Database
{
    private static ?PDO $pdo = null;


    public static function conn(): PDO
    {
        if (self::$pdo === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8mb4';
            self::$pdo = new PDO($dsn, Config::DB_USER, Config::DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
    }
}
