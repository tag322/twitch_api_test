<?php

namespace App\Routing;

require 'vendor/autoload.php'; 

use GuzzleHttp\Client;

use App\Database\Connection;
use App\DBRead;

class Router {
    function notFound() {
        header("HTTP/1.0 404 Not Found");
    
        return 'Нет такой страницы';
    }

    function index() {
        ob_start();

        include 'app/Pages/index.php';

        $content = ob_get_clean();

        return $content;
    }

    function redirect() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        file_put_contents('logs/paths.txt', $path."\n", FILE_APPEND);

        ob_start();

        include 'app/Pages/redirect.php';

        $content = ob_get_clean();

        return $content;
    }

    function API_storeUserInfo() {

        $env = parse_ini_file(__DIR__.'/../../.env');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            $json = file_get_contents("php://input");

            switch($env["LOGGING_MODE"]) {
                case 'none':
                    return json_encode('logging disabled');
                case 'txt':
                    file_put_contents('logs/log.txt', $json, FILE_APPEND);
                    return json_encode('logged into \logs\log.txt');
                case 'pgsql':
                    try {
                        $pdo = Connection::get()->connect();
                        $sql = "INSERT INTO user_info_logs (logs) VALUES (:logs)";
                        $request = $pdo->prepare($sql);
                        $request->execute(['logs' => $json]);
                    } catch (\PDOException $e){
                        return $e;
                    }
                    return json_encode('logged to database');
            }
        }
    }
}
