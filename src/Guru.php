<?php

namespace LittleGuru\Guru;


class Guru
{


    public static function withKeys($url, $publicKey, $privateKey)
    {
        $token = new ApiToken($publicKey, $privateKey);
        
         return new ApiConnection($url, $token->getToken(), 'Token');
    }
    
    public static function withUserToken($url, $userToken)
    {
    
        return new ApiConnection($url, $userToken, 'User');

    }
    
    public static function getUserToken($url, $endpoint, $email, $password)
    {
        $connection = new ApiConnection($url, null, null);
        $resposne = $connection->post($endpoint, ['email' => $email, 'password' => $password]);
        
        return $resposne;
        
    }
    
    public static function decodeUserToken($token)
    {
        $parts = explode($token);
        
        if(count($parts) < 3)
        {
            return null;
        }
        
        $baseDecoded = base64_decode($parts[1]);
        
        if(!$baseDecoded)
        {
            return null;
        }
        
        $json = json_decode($baseDecoded);
        
        if(!$json)
        {
            return null;
        }
        
        return $json;
        
    }







}