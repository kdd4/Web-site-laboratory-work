<?php
namespace Controllers;

use \Core\Controller;

class MyInterestsController extends Controller {
    
    public function interests() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render(null, ['data' => 'Wrong method']);
            return;
        }

        $interests = $this->model->interests;

        $this->view->render(null, ['data' => $interests]);
    }
}