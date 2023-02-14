<?php

namespace App\Models;

use App\Database\Conexao;

class User
{
    private $query;
    private $pdo; 

    public function __construct()
    {
        $this->pdo = new Conexao();
    }

    public function login(array $data): object | bool
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $this->query = $this->pdo->getConexao()->prepare($sql);
        $this->query->bindValue(':email',$data['email']);
        $this->query->execute();

        return $this->query->fetch(\PDO::FETCH_OBJ);
    }

    public function createUser(array $data):bool
    {
        $sql = "INSERT INTO usuarios (nome,email,senha) VALUES (:nome,:email,:senha)";
        $this->query = $this->pdo->getConexao()->prepare($sql);
        $this->query->bindValue(':nome',htmlspecialchars($data['nome']));
        $this->query->bindValue(':email',htmlspecialchars($data['email']));
        $this->query->bindValue(':senha',$this->hash($data['senha']));
        return  $this->query->execute();
    }

    public function hash(string $data)
    {
        return password_hash($data,PASSWORD_DEFAULT);
    }

}    