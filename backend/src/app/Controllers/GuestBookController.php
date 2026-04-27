<?php
namespace Controllers;

use \Core\Controller;
use \Models\GuestBookModel;

class GuestBookController extends Controller {
    
    public function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(null, ['data' => 'Wrong method']);
            return;
        }

        foreach ($_POST as $key => $value) {
            $this->model->$key = $value;
        }
        $this->model->date = date('d.m.y');

        if ($this->model->validate($_POST)) {
            $this->model->save();
        }

        $data = $this->model->validator->ShowErrors();

        $this->view->render(null, ['data' => $data]);
    }

    public function feedback() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render('layout.php', ['data' => 'Wrong method']);
            return;
        }

        $data = GuestBookModel::load();

        $this->view->render(null, ['data' => $data]);
    }
}