<?
namespace Core;

class Router
{
    public static function route()
    {
        $controllerName = $_REQUEST["controller"] ?? "page";
        $actionName = $_REQUEST['action'] ?? "index";

        $splitedControllerName = preg_split('/-/', $controllerName);

        if (!$splitedControllerName) {
            die("Error: split '$controllerName' by '-' error");
        }

        $upperSplitedControllerName = array_map('ucfirst', $splitedControllerName);

        $CamelCaseControllerName = implode('', $upperSplitedControllerName);

        $controllerClass = 'Controllers\\' . $CamelCaseControllerName . 'Controller';
        echo $controllerClass;
        $controller = new $controllerClass;

        if (!method_exists($controller, $actionName)) {
            die("Error: Method $actionName not found in controller $controllerClass");
        }

        $controller->$actionName();
    }
}