<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Models\BlogModel;

/** @property \Models\BlogModel $model */
class BlogController extends Controller {

    #[AllowedMethods('POST')]
    public function post() {
        if (!isset($_FILES['image'])) {
            $this->view->render(['data' => '"image" field not found'], code: 400);
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

        $validationResult = $this->model->validate();

        if ($validationResult) {
            $this->model->save();
        }

        $data = $this->model->validator->ShowErrors();
        $this->view->render(['data' => $data], code: $validationResult ? null : 400);
    }

    #[AllowedMethods('POST')]
    public function postfile() {
        if (!isset($_FILES['posts'])) {
            $this->view->render(['data' => 'file not found'], code: 400);
            return;
        }

        if (!is_uploaded_file($_FILES['posts']['tmp_name'])) {
            $this->view->render(['data' => 'upload file error'], code: 400);
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

    #[AllowedMethods('GET')]
    public function posts() {
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
    }

    #[AllowedMethods('GET')]
    public function image() {
        if (!isset($_GET['id'])) {
            $this->view->render(['data' => 'Parameter id not found'], code: 400);
            return;
        }

        $id = (int)$_GET['id'];

        $model = BlogModel::find($id);

        if ($model === null) {
            $this->view->render(['data' => "Blog id: $id not found"], code: 404);
            return;
        }

        $this->model = $model;

        if ($this->model->image === null) {
            $this->view->render(['data' => "Blog id: $id doesn't have image"], code: 404);
            return;
        }

        $this->view->render([
            'data' => $this->model->image,
            'type' => $this->model->imgtype
            ], 'resource.php');
    }
}