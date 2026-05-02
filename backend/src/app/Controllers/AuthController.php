<?php
namespace Controllers;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;
use Models\AuthModel;

/** @property \Models\AuthModel $model */
class AuthController extends Controller {
    
    #[AllowedMethods('GET')]
    #[RequireAuth()]
    public function roles() {
        $this->view->render(['data' => [
            'roles' => $_SESSION['roles']
        ]]);
    }

    #[AllowedMethods('GET')]
    public function status() {
        $this->view->render(['data' => [
            'auth' => isset($_SESSION['login'])
        ]]);
    }


    #[AllowedMethods('POST')]
    #[RequireAuth()]
    public function logout() {
        session_unset();

        $this->view->render(['data' => 'Ok']);
    }

    #[AllowedMethods('POST')]
    public function login() {
        if (!$this->model->validate()) {
            $data = $this->model->validator->ShowErrors();

            $this->view->render(['data' => $data], code: 400);
            return;
        }

        $user = AuthModel::findByFields(['login' => $_POST['login']]);

        if ($user === null) {
            $this->view->render(['data' => 'User not found'], code: 400);
            return;
        }

        if (!password_verify($_POST['password'], $user->password)) {
            $this->view->render(['data' => 'Password is wrong'], code: 400);
            return;
        }

        $roles = [];
        if ($this->model->roles !== null) {
            $roles = array_map(
                trim(...),
                explode(',', $this->model->roles)
                );
        }

        $_SESSION['login'] = $user->login;
        $_SESSION['roles'] = $roles;

        $this->view->render(['data' => 'Ok']);
    }

    #[AllowedMethods('POST')]
    public function register() {
        if (!$this->model->validate()) {
            $data = $this->model->validator->ShowErrors();

            $this->view->render(['data' => $data], code: 400);
            return;
        }

        if ($this->model->alreadyExists()) {
            $this->view->render(['data' => 'Already exists'], code: 400);
            return;
        }

        $this->model->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $this->model->save();

        $roles = [];
        if ($this->model->roles !== null) {
            $roles = array_map(
                trim(...),
                explode(',', $this->model->roles)
                );
        }
    
        $_SESSION['login'] = $this->model->login;
        $_SESSION['roles'] = $roles;

        $this->view->render(['data' => 'Ok']);
    }
}