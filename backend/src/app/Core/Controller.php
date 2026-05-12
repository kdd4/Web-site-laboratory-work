<?php
namespace Core;

use function get_class, is_array;

class Controller
{
    /** @var Model */
    protected $model;
    protected View $view;
    
    public function __construct()
    {
        $this->view = new View();

        $className = get_class($this); // Controllers\...Controller
        $modelClass = preg_replace('/Controller/', 'Model', $className);

        $this->model = new $modelClass;

        $this->loadRequest();
    }

    protected function loadRequest() {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' && (
                $contentType === 'application/x-www-form-urlencoded' ||
                str_starts_with($contentType, 'multipart/form-data')
            )
        ) {
            foreach ($_POST as $key => $value) {
                $this->model->$key = $value;
            }
        }
        
        if ($contentType === 'application/json') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $this->model->$key = $value;
                }
            }
        }
        
        if ($contentType === 'application/xml') {
            $xml = simplexml_load_string(file_get_contents('php://input'));

            if ($xml !== false) {
                foreach ($xml->children() as $key => $value) {
                    $this->model->$key = (string) $value;
                }
            }
        }
    }
}