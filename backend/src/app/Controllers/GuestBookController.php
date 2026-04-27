<?php
namespace Controllers;

use \Core\Controller;
use \Models\GuestBookModel;

class GuestBookController extends Controller {
    public function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        foreach ($_POST as $key => $value) {
            $this->model->$key = $value;
        }
        $this->model->date = date('d.m.y');

        foreach ($_POST as $key => $value) {
            $this->model->$key = $value;
        }

        if ($this->model->validate()) {
            $this->model->save();
        }

        $data = $this->model->validator->ShowErrors();

        $this->view->render(['data' => $data]);
    }

    public function file() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $file = GuestBookModel::loadFile();
            $this->view->render(['data' => $file], 'layout.php');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        if (!isset($_FILES['feedbackFile']) || $_FILES['feedbackFile']['error'] !== UPLOAD_ERR_OK) {
            $this->view->render(['data' => 'The file was not sent']);
            return;
        }

        $result = move_uploaded_file($_FILES['feedbackFile']['tmp_name'], GuestBookModel::getFileName());

        $this->view->render(['data' => $result ? 'Ok' : 'Error loading file']);
    }

    public function feedback() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        $data = GuestBookModel::load();

        $this->view->render(['data' => $data]);
    }
}