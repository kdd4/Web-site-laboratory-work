<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;

/** @property \Models\ContactModel $model */
class ContactController extends Controller {
    
    #[AllowedMethods('POST')]
    #[RequireAuth()]
    public function form() {
        $res = $this->model->validate();

        $data = $this->model->validator->ShowErrors();

        $this->view->render(['data' => $data], code: $res ? null : 400);
    }
}