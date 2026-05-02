<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;

/** @property \Models\PhotoAlbumModel $model */
class PhotoAlbumController extends Controller {

    #[AllowedMethods('GET')]
    public function album() {
        $album = $this->model->album;

        $this->view->render(['data' => $album]);
    }
}