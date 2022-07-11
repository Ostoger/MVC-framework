<?php

declare(strict_types=1);

namespace app\core;

use Exception;
use Psr\Log\LogLevel;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    private Logger $log;
    public Database $db;

    public function __construct()
    {
        self::$app = $this;
        $this->log = new Logger(__DIR__ . '/../runtime/logFile.txt');
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    }

    public function run(): void
    {
        try {
            $this->router->resolve();
        } catch (Exception $e){
            $this->log->log(LogLevel::ERROR, 'can not solve request');
            $this->response->setStatusCode(Response::HTTP_SERVER_ERROR);
        }
    }
}