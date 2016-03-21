<?php
/**
 * User: Chris Endcliffe
 * Date: 17/03/16
 * Time: 20:42
 */

namespace LittleGuru\Guru;


class ApiConnection
{

    protected $token;

    protected $lastError;

    public function __construct( $token)
    {

       $this->token = $token;



    }

    private function connection()
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, 'Authorization: '. $this->token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        return $ch;

    }

    public function get($url, array $params)
    {

        $ch = $this->connection();

        if ($params)
        {
            $url = $url . '?' . $this->prepareQuery($params);

            curl_setopt($ch, CURLOPT_URL, $url);
        }


        $result = curl_exec($ch);

        return $result;

    }

    private function prepareQuery(array $params){

        return http_build_query($params);

    }

    private function handleErrors()
    {

    }

}