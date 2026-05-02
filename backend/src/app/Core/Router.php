<?php
namespace Core;

class Router
{
    public static function route()
    {
        $controllerName = $_REQUEST["controller"] ?? "page";
        $actionName = $_REQUEST['action'] ?? "index";

        $splitedControllerName = preg_split('/-/', $controllerName);

        if (!$splitedControllerName) {
            exit("Error: split '$controllerName' by '-' error");
        }

        $upperSplitedControllerName = array_map('ucfirst', $splitedControllerName);

        $CamelCaseControllerName = implode('', $upperSplitedControllerName);

        $controllerClass = "Controllers\\{$CamelCaseControllerName}Controller";
        
        $controller = new $controllerClass;

        if (!method_exists($controller, $actionName)) {
            exit("Error: Method \"$actionName\" not found in controller \"$controllerClass\"");
        }

        $middleware = new Middleware();

        $middleware->buildPipeline($controller, $actionName);

        $middleware->runPipeline();
    }
}