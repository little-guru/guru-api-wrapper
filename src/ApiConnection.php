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

    protected $baseUrl;

    public function __construct($url, $token)
    {

       $this->token = $token;

        $this->baseUrl = $url;


    }

    private function connection()
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: '. $this->token]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        return $ch;

    }

    public function get($url, $params = array())
    {

        $ch = $this->connection();

        if ($params)
        {
            $url = $this->baseUrl . $url . '?' . $this->prepareQuery($params);


        }else {

            $url = $this->baseUrl . $url;
        }

        curl_setopt($ch, CURLOPT_URL, $url);


        $result = curl_exec($ch);

        curl_close($ch);

        return $result;

    }


    public function post($url, $params = array())
    {


        $ch = $this->connection();

        curl_setopt($ch, CURLOPT_POST, 1);

        if($params)
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1 );

        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;


    }

    private function prepareQuery(array $params){

        return http_build_query($params);

    }

    private function handleErrors()
    {

    }

}