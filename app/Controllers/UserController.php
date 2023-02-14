<?php 

namespace App\Controllers;

use App\Http\Controller;
use App\Models\User;
use App\Support\Validation;
use App\Support\TokenJwt;

class UserController extends Controller
{
    public function index($request,$response)
    {
        $data = [];
        $data['error'] = '';
        $contentType = $this->request($request);
        
        if (strstr($contentType->getHeaderLine('Content-Type'),'application/json')) {
            $payload = $this->input();

            Validation::Validate([
                'nome'=>'required|min:3',
                'email'=>'required|email',
                'senha'=>'required'
            ]);

            if (Validation::hasError()) {
                $data['error'] = Validation::getMessage();
                return $this->jsonResponse($data,$response,200);
            } 

            $user = new User;
            $user->createUser($payload);
            $data['data'] = "cadastrado com sucesso!";

            return $this->jsonResponse($data,$response,201);
        }
        
        $data['error'] = 'Cabeçalho não corresponde application/json';
        return $this->jsonResponse($data,$response,400);
    }

    public function logIn($request,$response)
    {
        $data = [];
        $data['error'] = '';
        $contentType = $this->request($request);
        
        if (strstr($contentType->getHeaderLine('Content-Type'),'application/json')) {
            $payload = $this->input();

            Validation::Validate([
                'email'=>'required|email',
                'senha'=>'required'
            ]);

            if (Validation::hasError()) {
                $data['error'] = Validation::getMessage();
                return $this->jsonResponse($data,$response,200);
            } 

            $user = new User;
            if ($user->login($payload)) {
                $token = new TokenJwt();
                $data['data'] = $token->generate($payload['email']);
                return $this->jsonResponse($data,$response,200);
            }
        }  
        
        $data['error'] = 'Cabeçalho não corresponde application/json';
        return $this->jsonResponse($data,$response,400);
    }

}