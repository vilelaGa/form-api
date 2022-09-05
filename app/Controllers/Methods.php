<?php

namespace App\Controllers;

use App\DbConnect\DbConnect;
use PDO;
use Exception;

class Methods
{
    public function Response($codigo, $msg)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Content-Type: Application/json");

        http_response_code($codigo);

        echo (json_encode([
            'msg' => $msg,
        ]));

        die;
    }

    public function Cadastrar($data)
    {
        $body = file_get_contents('php://input');

        if (!$body) {
            $this->Response(400, "Body is dead");
        }

        $body = json_decode($body);


        $obDatabase = new DbConnect("pessoas");

        $obDatabase->insert([
            'email' => $body->email,
            'senha' => $body->senha
        ]);
    }



    public function error($data)
    {
        echo "<h1>Erro {$data["errcode"]}</h1>";
    }
}
