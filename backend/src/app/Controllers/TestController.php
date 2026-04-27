<?php
namespace Controllers;

use \Core\Controller;

class TestController extends Controller {

    public function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        $result = [
            'result' => $this->model->validate($_POST)
        ];

        $this->view->render(['data' => $result]);
    }
}