<?php
namespace Controllers;

use \Firebase\JWT\JWT;

use \Core\Controller;
use \Core\Attributes\AllowedMethods;
use \Core\Attributes\RequireAuth;
use \Core\Attributes\CheckAuth;
use \Models\AuthModel;

/** @property \Models\AuthModel $model */
class AuthController extends Controller {
    
    #[AllowedMethods('GET')]
    #[RequireAuth()]
    public function roles(AuthModel $user) {
        $this->view->render(['data' => [
            'roles' => $user->getRoles()
        ]]);
    }

    #[AllowedMethods('GET')]
    #[CheckAuth()]
    public function status($isAuthenticated) {
        $this->view->render(['data' => [
            'auth' => $isAuthenticated
        ]]);
    }

    #[AllowedMethods('GET')]
    #[RequireAuth()]
    public function info(AuthModel $user) {
        $data = [];
        $fields = ['login', 'fio', 'email'];

        foreach ($fields as $key) {
            $data[$key] = $user->$key;
        }

        $this->view->render(['data' => $data]);
    }


    #[AllowedMethods('POST')]
    #[RequireAuth()]
    public function logout() {
        setcookie("JWT", "", time() - 3600, path: '/');

        $this->view->render(['data' => 'Ok']);
    }

    #[AllowedMethods('POST')]
    public function login() {
        $user = AuthModel::findByFields(['login' => $_POST['login']]);

        if ($user === null) {
            $this->view->render(['data' => 'User not found'], code: 400);
            return;
        }

        if (!password_verify($_POST['password'], $user->password)) {
            $this->view->render(['data' => 'Password is wrong'], code: 400);
            return;
        }

        $key = $_ENV['JWT_KEY'];
        $payload = $user->getPayload();

        $jwt = JWT::encode($payload, $key, 'HS256');

        setcookie('JWT', $jwt, [
            'path' => '/',
            'expires' => $payload['exp'],
            'httponly' => true
        ]);

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

        $key = $_ENV['JWT_KEY'];
        $payload = $this->model->getPayload();

        $jwt = JWT::encode($payload, $key, 'HS256');

        setcookie('JWT', $jwt, [
            'path' => '/',
            'expires' => $payload['exp'],
            'httponly' => true
        ]);

        $this->view->render(['data' => 'Ok']);
    }
}