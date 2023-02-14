<?php

namespace App\Models;

use App\Database\Conexao;

class Product
{
    private $query;
    private $pdo; 

    public function __construct()
    {
        $this->pdo = new Conexao();
    }

    public function pagination(int $offset):array | null
    {
        $limit = 10;
        $this->query = $this->pdo->getConexao()->prepare('SELECT * FROM produtos LIMIT :offset,'.$limit);
        $this->query->bindValue(':offset',($offset*10));
        $this->query->execute();
        return $this->query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function one(int $id):object | bool
    {
        $this->query = $this->pdo->getConexao()->prepare('SELECT * FROM produtos WHERE id = :id');
        $this->query->bindValue(':id',$id);
        $this->query->execute();
        return $this->query->fetch(\PDO::FETCH_OBJ);
    }

    public function createProduct(array $data):bool
    {
        $this->query = $this->pdo->getConexao()->prepare('INSERT INTO produtos (descricao,preco) VALUES (:descricao,:preco)');
        $this->query->bindValue(':descricao',htmlspecialchars($data['descricao']));
        $this->query->bindValue(':preco',htmlspecialchars($data['preco']));
        return $this->query->execute();
    }

    public function updateProduct(array $data):bool
    {
        $this->query = $this->pdo->getConexao()->prepare('UPDATE produtos SET descricao = :descricao,preco = :preco WHERE id = :id');
        $this->query->bindValue(':descricao',htmlspecialchars($data['descricao']));
        $this->query->bindValue(':preco',htmlspecialchars($data['preco']));
        $this->query->bindValue(':id',$data['id']);
        return $this->query->execute();
    }

    public function deleteProduct(int $id):bool
    {
        $this->query = $this->pdo->getConexao()->prepare('DELETE FROM produtos WHERE id = :id');
        $this->query->bindValue(':id',$id);
        return $this->query->execute();
    }
}