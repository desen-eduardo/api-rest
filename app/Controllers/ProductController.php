<?php 

namespace App\Controllers;

use App\Http\Controller;
use App\Models\Product;
use App\Support\Validation;
use App\Support\TokenJwt;

class ProductController extends Controller
{
    public function index($request,$response)
    {   
        $data = [];
        $data['error'] = '';

        $contentType = $this->request($request);
        
        if (strstr($contentType->getHeaderLine('Content-Type'),'application/json')) {

            if (!empty($this->autorization())) {
                $token = str_replace('Bearer ','',$this->autorization());
                $jwt = new TokenJwt;
                $dados = json_decode($jwt->auth($token),true);

                if (isset($dados['email'])) {
                    $payload = $this->request($request);
                    $page = $payload->getAttribute('page');
                    $page = (int) $page ?? 0;
     
                    $product = new Product;
                    $data['data'] = $product->pagination($page);
                    return $this->jsonResponse($data,$response,200);
                } 
                    $data['error'] = $dados;
                    return $this->jsonResponse($data,$response,401);
            } 

            $data['error'] = 'Not Autorization';
            return $this->jsonResponse($data,$response,401);
        }
        

        $data['error'] = 'Cabeçalho não corresponde application/json';
        return $this->jsonResponse($data,$response,400);
    }

    public function create($request,$response)
    {   
        $data = [];
        $data['error'] = '';

        $contentType = $this->request($request);
        
        if (strstr($contentType->getHeaderLine('Content-Type'),'application/json')) {

            if (!empty($this->autorization())) {
                $token = str_replace('Bearer ','',$this->autorization());
                $jwt = new TokenJwt;
                $dados = json_decode($jwt->auth($token),true);

                if (isset($dados['email'])) {
                    $payload = $this->input();

                    Validation::Validate([
                        'descricao'=>'required|min:3',
                        'preco'=>'required'
                    ]);

                    if (Validation::hasError()) {
                        $data['error'] = Validation::getMessage();
                        return $this->jsonResponse($data,$response,200);
                    } 

                    $product = new Product;
                    $product->createProduct($payload);

                    $data['data'] = "cadastrado com sucesso!";
                    return $this->jsonResponse($data,$response,201);
                } 
                    $data['error'] = $dados;
                    return $this->jsonResponse($data,$response,401);  
            }

            $data['error'] = 'Not Autorization';
            return $this->jsonResponse($data,$response,401);
        }

        $data['error'] = 'Cabeçalho não corresponde application/json';
        return $this->jsonResponse($data,$response,400);
    }

    public function read($request,$response)
    {
        $data = [];
        $data['error'] = '';

        $contentType = $this->request($request);
        
        if (strstr($contentType->getHeaderLine('Content-Type'),'application/json')) {

            if (!empty($this->autorization())) {
                $token = str_replace('Bearer ','',$this->autorization());
                $jwt = new TokenJwt;
                $dados = json_decode($jwt->auth($token),true);

                if (isset($dados['email'])) {
                    $payload = $this->request($request);
                    $id = (int) $payload->getAttribute('id');

                    $product = new Product;
                    $data['data'] = $product->updateProduct($id);
                    return $this->jsonResponse($data,$response,203);
                }

                $data['error'] = $dados;
                return $this->jsonResponse($data,$response,401);  

            }  
            
            $data['error'] = 'Not Autorization';
            return $this->jsonResponse($data,$response,401);
        }    
        
        $data['error'] = 'Cabeçalho não corresponde application/json';
        return $this->jsonResponse($data,$response,400);
    }

    public function update($request,$response)
    {
        $data = [];
        $data['error'] = '';

        $contentType = $this->request($request);
        
        if (strstr($contentType->getHeaderLine('Content-Type'),'application/json')) {

            if (!empty($this->autorization())) {
                $token = str_replace('Bearer ','',$this->autorization());
                $jwt = new TokenJwt;
                $dados = json_decode($jwt->auth($token),true);

                if (isset($dados['email'])) {
                    $payload = $this->input();

                    Validation::Validate([
                        'descricao'=>'required|min:3',
                        'preco'=>'required'
                    ]);

                    if (Validation::hasError()) {
                        $data['error'] = Validation::getMessage();
                        return $this->jsonResponse($data,$response,200);
                    } 

                    $product = new Product;
                    $product->updateProduct($payload);
                    $data['data'] = 'Alterado com sucesso!!!';

                    return $this->jsonResponse($data,$response,203);
                }

                $data['error'] = $dados;
                return $this->jsonResponse($data,$response,401);   
            }

            $data['error'] = 'Not Autorization';
            return $this->jsonResponse($data,$response,401);   
        }
        
        $data['error'] = 'Cabeçalho não corresponde application/json';
        return $this->jsonResponse($data,$response,400);       
    }

    public function delete($request,$response)
    {
        $data = [];
        $data['error'] = '';

        $contentType = $this->request($request);
        
        if (strstr($contentType->getHeaderLine('Content-Type'),'application/json')) {
            if (!empty($this->autorization())) {
                $token = str_replace('Bearer ','',$this->autorization());
                $jwt = new TokenJwt;
                $dados = json_decode($jwt->auth($token),true);

                if (isset($dados['email'])) {
                    $payload = $this->input();
                        
                    $product = new Product;
                    $product->deleteProduct($payload['id']);

                    $data['data'] = 'Excluido com sucesso!!!';
                    return $this->jsonResponse($data,$response,203);
                }  

                $data['error'] = $dados;
                return $this->jsonResponse($data,$response,401); 
            }
            
            $data['error'] = 'Not Autorization';
            return $this->jsonResponse($data,$response,401);
        }
        
        $data['error'] = 'Cabeçalho não corresponde application/json';
        return $this->jsonResponse($data,$response,400);      
    }
}