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
    const TYPE_VALIDATION_ERROR = 'validation_error';
    const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';

    static private $titles = array(
        self::TYPE_VALIDATION_ERROR => 'There was a validation error',
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent',
    );

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
        if (!isset(self::$titles[$type])) {
            throw new \InvalidArgumentException('No title for type '.$type);
        }

        $this->title = self::$titles[$type];
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
    public function toArray()
    {
        return array_merge(
            $this->extraData,
            [
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title,
            ]
        );
    }
}