<?
namespace Controller;

use Core\Controller;

class InfoController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $this->view->render('info.php');
    }
}