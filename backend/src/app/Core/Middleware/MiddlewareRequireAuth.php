<?php
namespace Core\Middleware;

use \Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

use \Core\Attributes\RequireAuth;
use \Models\AuthModel;

use function in_array;

class MiddlewareRequireAuth implements MiddlewareInterface {
    public function __construct(public RequireAuth $attribute) {}

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

        if (!isset($_COOKIE['JWT'])) {
            http_response_code(401);
            exit('Unauthorized');
        }

        $key = $_ENV['JWT_KEY'];
        $jwt = $_COOKIE['JWT'];

        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (ExpiredException $e) {
            http_response_code(401);
            exit('Expired');
        } catch (Exception $e) {
            http_response_code(401);
            exit('Invalid token' . $e->getMessage());
        }

        $user = AuthModel::find($decoded->sub);

        if ($this->attribute->role !== null && 
            !in_array($this->attribute->role, $user->getRoles())) {
            http_response_code(403);
            exit('Forbidden');
        }

        $params['user'] = $user;

        if (isset($next[0])) {
            $current = array_shift($next);
            $current->handle($next, $params);
        }
    }
}