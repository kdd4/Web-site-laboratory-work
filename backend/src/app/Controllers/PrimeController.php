<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;
use \Models\PrimeModel;

/** @property \Models\PrimeModel $model */
class PrimeController extends Controller {

    #[AllowedMethods('POST')]
    #[RequireAuth()]
    public function generate() {
        if ($this->model->length === null) {
            $this->view->render(['data' => 'Field "length" not found']);
            return;
        }

        $this->model->result = null;
        $this->model->time = date('Y-m-d H:i:s');

        $this->model->save();
        
        $this->view->render(['data' => [
            'id' => $this->model->id    
            ]]);

        fastcgi_finish_request();

        $this->model->generate();
    }

    #[AllowedMethods('GET')]
    #[RequireAuth()]
    public function result() {
        if (!isset($_GET['id'])) {
            $this->view->render(['data' => 'Field "id" not found']);
            return;
        }

        $id = (int) $_GET['id'];

        $model = PrimeModel::find($id);

        if ($model === null) {
            $this->view->render(['data' => "Task id: $id not found"]);
            return;
        }

        $this->view->render(['data' => [
            'result' => $model->result,
            ]]);

        if ($model->result !== null) {
            $model->delete();
        }
    }
}