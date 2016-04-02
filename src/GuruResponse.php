<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 02/04/16
 * Time: 22:34
 */

namespace LittleGuru\Guru;


class GuruResponse
{

    protected $description;

    protected $message;

    protected $httpStatus;

    protected $apiCode;

    protected $errors;

    protected $data;

    protected $pagination;


    public function __construct($description, $message, $httpStatus, $apiCode, $errors, $data, $pagination)
    {
        $this->description = $description;
        $this->message = $message;
        $this->httpStatus = $httpStatus;
        $this->apiCode = $apiCode;
        $this->errors = $errors;
        $this->data = $data;
        $this->pagination = $pagination;
    }


    public function __get($name)
    {
        return $this->{$name};

    }

}