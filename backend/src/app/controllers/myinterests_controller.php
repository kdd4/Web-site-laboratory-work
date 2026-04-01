<?
class MyInterestsController extends Core\Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function interests() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render("Wrong method", "", $this->model);
            return;
        }

        $interests = $this->model->interests;

        $this->view->render($interests, $this->model, 'json.php');
    }
}