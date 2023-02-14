<?php

namespace App\Database;

class Conexao
{
    private $pdo;

    public function getConexao()
    {
        try {
            $this->pdo = new \PDO('sqlite:'.__DIR__.'/../../docker/db/cadastro.db');
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
         
    }
}