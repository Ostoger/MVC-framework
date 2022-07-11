<?php

declare(strict_types=1);

namespace app\core;

class Request
{
    public function getPath()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    }


    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody(): array
    {
        $body = [];
        if ($this->getMethod() === 'get') {
            foreach ($_GET as $param => $value) {
                $body[$param] = filter_input(INPUT_GET, $param, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $param => $value) {
                $body[$param] = filter_input(INPUT_POST, $param, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }


}