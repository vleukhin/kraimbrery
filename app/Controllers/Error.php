<?php

namespace App\Controllers;

class Error
{
    public static function runStatic()
    {
        return new self();
    }

    public function E404Action()
    {
        http_response_code(404);
        readfile(dirname(__FILE__).'/../../error/404.html');
        die();
    }
}