<?php
namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTToken{

    function CreateToken($userEmail):string{

        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60*60,
            'userEmail' => $userEmail
        ];

         return JWT::create($payload,$key,'HS256');


    }

    function VerifyToken($token):string{

       try{
        $key = env('JWT_KEY');

        $decode = JWT::decode($token,new Key($key,'HS256'));

        return $decode->userEmail;
       }
       catch (Exception $e)
       {
        return 'unauthorized';

       }


    }
}