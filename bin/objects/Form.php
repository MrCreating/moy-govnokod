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

        parse_str($parseString, $_REQUEST);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parseString = file_get_contents('php://input');
            parse_str($parseString, $postData);
            $_REQUEST = array_merge($_REQUEST, $postData);
        }

        $data = array_merge($_REQUEST, array_merge($_GET, $_POST));

        return new self(array_filter($data, function ($item) {
            return !empty($item);
        }));
    }
}
