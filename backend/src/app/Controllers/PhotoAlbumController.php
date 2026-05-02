<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;

/** @property \Models\PhotoAlbumModel $model */
class PhotoAlbumController extends Controller {

    #[AllowedMethods('GET')]
    #[RequireAuth()]
    public function album() {
        $album = $this->model->album;

        $this->view->render(['data' => $album]);
    }
}