<?php 

namespace App\Support;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\BeforeValidException;

class TokenJwt
{
    
    public function generate(string $email):string
    {
        $time = time() + (1*24*60*60);

        $key = md5('jwt-php');
        $payload = [
            'email'=>$email,
            'iat'=>time(),
            'exp'=>$time
        ];

        return JWT::encode($payload, $key, 'HS256');
        
    }

    public function auth(string $jwt):string
    {   
        try{
            $key = md5('jwt-php');
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            return json_encode($decoded);

        } catch(\Exception $e) {
            return json_encode(['message'=>$e->getMessage()]);
        }
    }
}