<?php

namespace LittleGuru\Guru;


class Guru
{
    protected $token;

    protected $publicKey;

    protected $privateKey;

    protected $apiConnection;

    protected $url;

    /**
     * Guru constructor.
     * @param $privateKey
     * @param $publicKey
     * @param $url
     */
    public function __construct($publicKey, $privateKey,  $url)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->url = $url;
        $this->token = new ApiToken($this->publicKey, $this->privateKey);
        $this->apiConnection = $this->getConnection();


    }

    private function getConnection()
    {



        return new ApiConnection($this->url, $this->token->getToken());

    }

    public function get($endpoint, $params = array())
    {

        return $this->apiConnection->get($endpoint, $params = array());

    }

    public function post($endpoint, $params = array())
    {

        return $this->apiConnection->post($endpoint, $params);

    }




}