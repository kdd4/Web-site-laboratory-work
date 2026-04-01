<?
namespace Controllers;

use \Core\Controller;

class PhotoAlbumController extends Controller {

    public function album() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render('layout.php', ['data' => 'Wrong method']);
            return;
        }

        $album = $this->model->album;

        $this->view->render('json.php', ['data' => $album]);
    }
}