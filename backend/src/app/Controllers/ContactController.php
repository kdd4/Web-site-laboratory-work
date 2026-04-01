<?
namespace Controller;

use Core\Controller;

class ContactController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render('layout.php', ['data' => 'Wrong method']);
            return;
        }

        $this->model->validate($_POST);

        $data = $this->model->validator->ShowErrors();

        $this->view->render('layout.php', ['data' => $data]);
    }
}