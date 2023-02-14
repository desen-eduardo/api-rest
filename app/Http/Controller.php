<?php

namespace App\Http;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Controller
{
    private $request;

    public function input():array
    {
        $_POST = json_decode(file_get_contents('php://input'),true);
        return $_POST;
    }

    public function request(Request $request):Request
    {
        return $this->request = $request;
    }

    public function jsonResponse(array $data,Response $response,int $status):Response
    {
        $response->getBody()->write(json_encode($data));
        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
    }

    protected function autorization():string | null
    {
        $autorization = $_SERVER['HTTP_AUTORIZATION']??null;
        return $autorization;
    }
}