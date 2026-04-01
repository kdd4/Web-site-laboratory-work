<?
namespace Core;

class Controller
{
    protected $model;
    protected $view;
    
    public function __construct()
    {
        $this->view = new View();

        $className = get_class($this); // Controllers\...Controller
        $modelClass = preg_replace('/Controller/', 'Model', $className);

        $this->model = new $modelClass;
    }
}