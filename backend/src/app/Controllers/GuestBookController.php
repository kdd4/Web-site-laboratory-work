<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;
use \Models\GuestBookModel;

/** @property \Models\GuestBookModel $model */
class GuestBookController extends Controller {

    #[AllowedMethods('POST')]
    #[RequireAuth()]
    public function form() {
        $this->model->date = date('d.m.y');

        if ($this->model->validate()) {
            $this->model->save();
        }

        $data = $this->model->validator->ShowErrors();

        $this->view->render(['data' => $data]);
    }

    #[AllowedMethods('GET', 'POST')]
    #[RequireAuth('admin')]
    public function file() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $file = GuestBookModel::loadFile();
            $this->view->render(['data' => $file], 'layout.php');
            return;
        }

        if (!isset($_FILES['feedbackFile']) || $_FILES['feedbackFile']['error'] !== UPLOAD_ERR_OK) {
            $this->view->render(['data' => 'file not found or has upload error'], code: 400);
            return;
        }

        if (!is_uploaded_file($_FILES['feedbackFile']['tmp_name'])) {
            $this->view->render(['data' => 'Error loading file'], code: 400);
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

    #[AllowedMethods('GET')]
    public function feedback() {
        $data = GuestBookModel::load();

        $this->view->render(['data' => $data]);
    }
}