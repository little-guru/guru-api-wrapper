<?php

namespace LittleGuru\Guru;


class ApiToken
{

    protected $privateKey;

    protected $publicKey;

    protected $blob;

    protected $token;

    protected $signature;

    /**
     * ApiToken constructor.
     * @param $privateKey
     * @param $publicKey
     */
    public function __construct($publicKey, $privateKey)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;

        $this->create();
    }


    private function create()
    {

        $this->blob = $this->generateRandomString(10);

        $this->signature = $this->sign($this->blob, $this->privateKey);

        $this->token = $this->publicKey . '.' . $this->blob . '.'. $this->signature;


    }

    private function generateRandomString($length)
    {

        $string = openssl_random_pseudo_bytes($length, $strong);

        if($strong)
        {
            return bin2hex($string);
        }

        return null;


    }

    /**
     * @param $blob
     * @param $privateKey
     * @return null|string
     */
    private function sign($blob, $privateKey)
    {


        if(is_string($blob))
        {
            return hash_hmac('sha256', $blob, $privateKey);
        }


        return null;


    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @return mixed
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }


    public function __toString()
    {
        return $this->token;

    }


}