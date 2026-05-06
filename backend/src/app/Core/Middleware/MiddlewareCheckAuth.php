<?php
namespace Core\Middleware;

use \Exception;

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

use \Core\Attributes\CheckAuth;
use \Models\AuthModel;

use function in_array;

class MiddlewareCheckAuth implements MiddlewareInterface {
    public function __construct(public CheckAuth $attribute) {}

    public function handle(array $next, array $params): void {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($this->attribute->forMethods !== null && 
            !in_array($method, $this->attribute->forMethods)) {

            if (isset($next[0])) {
                $current = array_shift($next);
                $current->handle($next, $params);
            }
            return;
        }

        $params['isAuthenticated'] = false;

        if (!isset($_COOKIE['JWT'])) {
            if (isset($next[0])) {
                $current = array_shift($next);
                $current->handle($next, $params);
            }
            return;
        }

        $key = $_ENV['JWT_KEY'];
        $jwt = $_COOKIE['JWT'];

        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (Exception $e) {
            if (isset($next[0])) {
                $current = array_shift($next);
                $current->handle($next, $params);
            }
            return;
        }

        $user = AuthModel::find($decoded->sub);

        if ($this->attribute->role !== null && 
            !in_array($this->attribute->role, $user->getRoles())) {
            if (isset($next[0])) {
                $current = array_shift($next);
                $current->handle($next, $params);
            }
            return;
        }

        $params['isAuthenticated'] = true;

        if (isset($next[0])) {
            $current = array_shift($next);
            $current->handle($next, $params);
        }
    }
}