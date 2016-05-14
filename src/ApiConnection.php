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
    
    protected $tokenType;
    
    protected $accountId;

    public function __construct($url, $token, $tokenType)
    {

       $this->token = $token;

        $this->baseUrl = $url;
        
        $this->tokenType = $tokenType;
        
        $this->accountId = null;


    }
    
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    private function connection()
    {

        $ch = curl_init();

        $headers = ['Authorization: '. $this->tokenType . ' ' . $this->token];

        if(strtolower($this->tokenType) == 'user' && !$this->accountId)
        {
            throw new \Exception('Account ID not set', 400);
        }

        $headers[] = 'GuruAccountId: '. $this->accountId;


        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


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

        $httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

        curl_close($ch);

        return $this->prepareResponse($result, $httpCode);

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

        $httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

        curl_close($ch);

        return $this->prepareResponse($result, $httpCode);


    }

    private function prepareQuery(array $params){

        return http_build_query($params);

    }

    private function prepareResponse($jsonString, $httpStatus)
    {

        $obj = json_decode($jsonString);


        if(!$obj)
        {
            return new GuruResponse(null, null, $httpStatus, null, ['Error connecting to the api'], null, null);
        }

        $pagination = null;

        if(isset($obj->pagination))
        {
            $pagination = $obj->pagination;
        }


        return new GuruResponse($obj->description, $obj->message, $httpStatus, $obj->code, $obj->errors,  $obj->data, $pagination);

    }

    private function handleErrors()
    {

    }

}