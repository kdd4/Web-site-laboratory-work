<?php
namespace Controllers;

use \Core\Controller;

class TestController extends Controller {

    public function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        foreach ($_POST as $key => $value) {
            $this->model->$key = $value;
        }

        $result = [
            'result' => $this->model->validate()
        ];

        $this->view->render(['data' => $result]);
    }
}