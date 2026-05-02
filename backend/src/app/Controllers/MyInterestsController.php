<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;

/** @property \Models\MyInterestsModel $model */
class MyInterestsController extends Controller {

    #[AllowedMethods('GET')]
    #[RequireAuth()]
    public function interests() {
        $interests = $this->model->interests;

        $this->view->render(['data' => $interests]);
    }
}