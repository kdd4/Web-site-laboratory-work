<?php
namespace Core\Middleware;

use \Core\Attributes\RequireAuth;

use function in_array, func_get_args;

class MiddlewareRequireAuth implements MiddlewareInterface {
    public function __construct(public RequireAuth $attribute) {}

    public function handle(?MiddlewareInterface $next): void {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($this->attribute->forMethods !== null && 
            !in_array($method, $this->attribute->forMethods)) {
            
            $args = func_get_args();
            array_shift($args);
            $next->handle(...$args);
            return;
        }

        if (!isset($_SESSION['login']) ) {
            http_response_code(401);
            exit('Unauthorized');
        }

        if ($this->attribute->role !== null && 
            !in_array(
                $this->attribute->role, 
                $_SESSION['roles']
                ) ?? []) {
            http_response_code(403);
            exit('Forbidden');
        }

        $args = func_get_args();
        array_shift($args);
        $next->handle(...$args);
    }
}