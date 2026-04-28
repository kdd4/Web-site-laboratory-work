<?php
namespace Controllers;

use \Core\Controller;
use Models\BlogModel;

class BlogController extends Controller {
    public function post() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        if (!isset($_FILES['image'])) {
            $this->view->render(['data' => '"image" field not found']);
            return;
        }

        $this->model->image = null;
        $this->model->imgtype = null;

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $stream = fopen($_FILES['image']['tmp_name'], 'rb');

            $this->model->image = $stream;
            $this->model->imgtype = $_FILES['image']['type'];
        }

        $this->model->time = date('Y-m-d H:i:s');

        if ($this->model->validate()) {
            $this->model->save();
        }

        $data = $this->model->validator->ShowErrors();
        $this->view->render(['data' => $data]);
    }

    public function postfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        if (!isset($_FILES['posts'])) {
            $this->view->render(['data' => 'file not found']);
            return;
        }

        if (!is_uploaded_file($_FILES['posts']['tmp_name'])) {
            $this->view->render(['data' => 'upload file error']);
            return;
        }

        $file = fopen($_FILES['posts']['tmp_name'], 'r');
        $fields = fgetcsv($file, separator:";", escape:"\\");

        // For files starts with BOM
        if ($fields !== false) {
            $fields[0] = ltrim($fields[0], "\xEF\xBB\xBF");
        }

        while (($row = fgetcsv($file, separator:";", escape:"\\")) !== false) {
            $model = new BlogModel();

            foreach ($fields as $key => $field) {
                $model->$field = $row[$key];
            }

            if (!$model->validate()) {
                continue;
            }

            $model->save();
        }

        fclose($file);
        $this->view->render(['data' => 'Ok']);
    }

    public function posts() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        $data = BlogModel::findAll();

        $filteredData = array_map(
            function($result) {
                $filtered = [];
                $fields = ['id', 'fio', 'theme', 'imgtype', 'text', 'time'];

                foreach ($fields as $value) {
                    $filtered[$value] = $result->$value;
                }

                return $filtered;
            }, 
            $data
        );

        $this->view->render(['data' => $filteredData]);
        return;
    }

    public function image() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        if (!isset($_GET['id'])) {
            $this->view->render(['data' => 'Parameter id not found']);
            return;
        }

        $id = (int)$_GET['id'];

        $model = BlogModel::find($id);

        if ($model === null) {
            $this->view->render(['data' => "Blog id: $id not found"]);
            return;
        }

        $this->model = $model;

        if ($this->model->image === null) {
            $this->view->render(['data' => "Blog id: $id doesn't have image"]);
            return;
        }

        $this->view->render([
            'data' => $this->model->image,
            'type' => $this->model->imgtype
            ], 'resource.php');
    }
}