<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;
use \Models\VisitsModel;

/** @property \Models\VisitsModel $model */
class VisitsController extends Controller {
    
    #[AllowedMethods('POST')]
    public function visit() {
        if (!$this->model->validate()) {
            $data = $this->model->validator->ShowErrors();

            $this->view->render(['data' => $data], code: 400);
            return;
        }

        $browserInfo = @get_browser();

        $this->model->time = date('Y-m-d H:i:s');
        $this->model->ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $this->model->host = $_SERVER['REMOTE_HOST'] ?? null;
        $this->model->browser = null;

        if ($browserInfo !== false && $browserInfo !== null) {
            $this->model->browser = $browserInfo->browser ?? null;
        }

        $this->model->save();

        $this->view->render(['data' => 'OK']);
    }

    #[AllowedMethods('GET')]
    #[RequireAuth('admin')]
    public function index() {
        $data = VisitsModel::findAll();

        $filteredData = array_map(
            function($result) {
                $filtered = [];
                $fields = ['time', 'page', 'ip', 'host', 'browser'];

                foreach ($fields as $value) {
                    $filtered[$value] = $result->$value;
                }

                return $filtered;
            }, 
            $data
        );

        $this->view->render(['data' => $filteredData]);
    }

    public function info() {
        phpinfo();
    }

}