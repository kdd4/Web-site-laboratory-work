<?
namespace Controller;

use Core\Controller;

class MyInterestsController extends Controller {


    public function interests() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render('layout.php', ['data' => 'Wrong method']);
            return;
        }

        $interests = $this->model->interests;

        $this->view->render('json.php', ['data' => $interests]);
    }
}