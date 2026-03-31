<?
namespace Core;

class Router
{
    static function route()
    {
        $controller_name = $_REQUEST["controller"] ? $_REQUEST["controller"] : "page";
        $action_name = $_REQUEST['action'] ? $_REQUEST['action'] : "index";

        $controller_file = "app/controllers/".$controller_name.'_controller.php';
        $model_file = "app/models/".$controller_name.'_model.php';

        // Loading controller
        if(!file_exists($controller_file)){
            die "Error: Controller file $controller_file not exists";
        }

        include $controller_file;

        $controller_class_name = ucfirst($controller_name).'Controller';
        $controller = new $controller_class_name;

        // Loading model
        if(!file_exists($model_file)) {
            die "Error: Model file $model_file not exists";
        }

        include $model_file;

        $model_class_name = ucfirst($controller_name).'Model';
        $model = new $model_class_name;

        $controller->model = $model;

        if(!method_exists($controller, $action_name)) {
            die "Error: Method $action_name not found in controller $controller_class_name";
        }

        $controller->$action_name();
    }
}