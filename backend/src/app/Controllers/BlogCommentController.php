<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;
use Models\AuthModel;
use Models\BlogCommentModel;

/** @property \Models\BlogCommentModel $model */
class BlogCommentController extends Controller {

    #[AllowedMethods('POST')]
    #[RequireAuth()]
    public function post(AuthModel $user) {
        $this->model->userID = $user->id;
        $this->model->time = date('Y-m-d H:i:s');

        $validateResult = $this->model->validate();

        if ($validateResult) {
            $this->model->save();
        }

        $data = $this->model->validator->ShowErrors();
        $this->view->render(['data' => $data], code: $validateResult ? null : 400);
    }

    #[AllowedMethods('GET')]
    #[RequireAuth()]
    public function comments() {
        if (!isset($_GET['id'])) {
            $this->view->render(['data' => 'Parameter id not found'], code: 400);
            return;
        }

        $id = (int)$_GET['id'];

        $comments = BlogCommentModel::findAllByFields([
            'blogID' => $id,
        ]);

        $results = array_map(function($comment) {
            $data = [
                'text' => $comment->text, 
                'time' => $comment->time,
            ];

            if ($comment->userID === null) {
                return $data;
            }
            
            $user = AuthModel::find($comment->userID);

            if ($user === null) {
                return $data;
            }

            $data['fio'] = $user->fio;

            return $data;
        }, $comments);

        $this->view->render([
            'data' => $results,
        ]);
    }
}