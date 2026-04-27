<?php
namespace Controllers;

use \Core\Controller;

class InfoController extends Controller {

    public function index() {
        $this->view->render([], 'info.php');
    }
}