<?php

declare(strict_types=1);

define("HOST","");
define("DATABASENAME","");
define("USER","");
define("PASSWORD","");

//conexao simples com banco de dados mysql
class Conexao
{
    private static ?PDO $pdo = null;

    public function __construct()
    {
        ini_set('display_errors', 'On');
        ini_set('error_reporting', E_ALL);
        $this->conectar();
    }

    protected function conectar(): ?PDO
    {
        try {
            if (is_null(self::$pdo)) {
                self::$pdo = new PDO(
                    'mysql:host=' . HOST .
                    ';dbname=' . DATABASENAME,
                    USER,
                    PASSWORD,
                    [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$pdo;
        } catch (PDOException $err) {
            echo "Erro: " . $err->getMessage() . "<br>";
            echo "Erro: " . $err->getTraceAsString();
            return null;
        }
    }
}
