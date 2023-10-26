<?php

namespace l\objects;

class Form extends BaseObject
{
    public function __construct(array $params = [])
    {
        parent::__construct($params, false);
    }

    /**
     * @throws \Exception
     */
    public static function load (): self
    {
        $string = explode("?", $_SERVER["REQUEST_URI"]);
        $parseString = $string[1] ?? '';

        if (empty($parseString) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $parseString = file_get_contents('php://input');
        }

        parse_str($parseString, $_REQUEST);
        $data = array_merge($_REQUEST, array_merge($_GET, $_POST));

        return new self($data);
    }
}
