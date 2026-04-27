<?php
namespace Core;

class Controller
{
    protected $model;
    protected View $view;
    
    public function __construct()
    {
        $this->view = new View();

        $className = get_class($this); // Controllers\...Controller
        $modelClass = preg_replace('/Controller/', 'Model', $className);

        $this->model = new $modelClass;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $this->model->$key = $value;
            }
        }
    }
}