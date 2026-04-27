<?php
namespace Controllers;

use \Core\Controller;
use \Models\TestModel;

class TestController extends Controller {

    public function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        $this->model->date = date('Y-m-d');
        $this->model->result = $this->model->validate();

        $this->model->save();
        
        $this->view->render(['data' => [
            'result' => $this->model->result
            ]]);
    }

    public function results() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render(['data' => 'Wrong method']);
            return;
        }

        $data = TestModel::findAll();

        $filteredData = array_map(
            function($result) {
                $filtered = [];

                foreach (['date', 'fio', 'result'] as $value) {
                    $filtered[$value] = $result->$value;
                }

                return $filtered;
            }, 
            $data
        );

        $this->view->render(['data' => $filteredData]);
    }
}