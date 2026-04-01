<?
namespace Controller;

use Core\Controller;

class TestController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function form() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->render('layout.php', ['data' => 'Wrong method']);
            return;
        }

        $result = [
            'result' => $this->model->validate($_POST)
        ];

        $this->view->render('json.php', ['data' => $result]);
    }
}