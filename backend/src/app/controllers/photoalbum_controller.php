<?
class PhotoAlbumController extends Core\Controller {
    function __construct()
    {
        parent::__construct();
    }

    function album() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->render("Wrong method", "", $this->model);
            return;
        }

        $album = $this->model->album;

        $this->view->render($album, $this->model, 'json.php');
    }
}