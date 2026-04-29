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

        $this->model->date = date('d.m.y');

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
            $this->view->render(['data' => 'file not found or has upload error']);
            return;
        }

        if (!is_uploaded_file($_FILES['feedbackFile']['tmp_name'])) {
            $this->view->render(['data' => 'Error loading file']);
            return;
        }

        $feedbacks = GuestBookModel::load($_FILES['feedbackFile']['tmp_name']);

        foreach ($feedbacks as $feedback) {
            $model = new GuestBookModel();

            foreach ($feedback as $key => $value) {
                $model->$key = $value;
            }

            $model->save();
        }

        $this->view->render(['data' => 'Ok']);
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