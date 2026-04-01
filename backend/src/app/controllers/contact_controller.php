<?
class ContactController extends Core\Controller {
    function __construct()
    {
        parent::__construct();
    }

    function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render("Wrong method", "", $this->model);
            return;
        }

        $this->model->validate($_POST);

        $this->view->render("", $this->model, 'validateResult.php');
    }
}