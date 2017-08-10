<?php

/**
 * Created by PhpStorm.
 * User: sydorenkovd
 * Date: 10.08.17
 * Time: 21:49
 */
namespace KnpU\CodeBattle\Api;
class ApiProblem
{
    private $statusCode;

    private $type;

    private $title;
    private $extraData = array();

    public function set($name, $value)
    {
        $this->extraData[$name] = $value;
    }
    public function __construct($statusCode, $type, $title)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;
        $this->title = $title;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}