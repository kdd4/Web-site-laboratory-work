<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;

/** @property \Models\MyInterestsModel $model */
class MyInterestsController extends Controller {

    #[AllowedMethods('GET')]
    public function interests() {
        $interests = $this->model->interests;

        $this->view->render(['data' => $interests]);
    }
}