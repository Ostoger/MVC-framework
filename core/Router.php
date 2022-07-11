<?php

declare(strict_types=1);

namespace app\core;

use Exception;

class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function setGetRoutes($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function setPostRoutes($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            return call_user_func($callback, $this->request);
        }

        if ($callback === false) {
            $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
            exit;
        }

        throw new Exception('not existing type');

    }

    public function renderView(string $view, array $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        include_once __DIR__ . "/../views/$view.php";
    }


}