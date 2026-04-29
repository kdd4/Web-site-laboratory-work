<?php
namespace Controllers;

use \Core\Controller;

class AuthController extends Controller {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        if (!$this->model->validate()) {
            $data = $this->model->validator->ShowErrors();

            $this->view->render(['data' => $data]);
            return;
        }

        $this->model->save();
    }
}