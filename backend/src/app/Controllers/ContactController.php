<?php
namespace Controllers;

use \Core\Controller;

class ContactController extends Controller {
    public function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        $this->model->validate();

        $data = $this->model->validator->ShowErrors();

        $this->view->render(['data' => $data]);
    }
}