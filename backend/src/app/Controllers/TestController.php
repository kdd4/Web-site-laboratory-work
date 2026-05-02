<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Models\TestModel;

/** @property \Models\TestModel $model */
class TestController extends Controller {

    #[AllowedMethods('POST')]
    public function form() {
        $this->model->date = date('Y-m-d');
        $this->model->result = $this->model->validate();

        $this->model->save();
        
        $this->view->render(['data' => [
            'result' => $this->model->result
            ]]);
    }

    #[AllowedMethods('GET')]
    public function results() {
        $data = TestModel::findAll();

        $filteredData = array_map(
            function($result) {
                $filtered = [];
                $fields = ['date', 'fio', 'result'];

                foreach ($fields as $value) {
                    $filtered[$value] = $result->$value;
                }

                return $filtered;
            }, 
            $data
        );

        $this->view->render(['data' => $filteredData]);
    }
}