<?php
namespace Core\Middleware;

use \Core\Attributes\RequireAuth;

use function in_array, func_get_args;

class MiddlewareRequireAuth implements MiddlewareInterface {
    public function __construct(public RequireAuth $attribute) {}

    public function handle(?MiddlewareInterface $next): void {    
        if (!in_array('login', $_SESSION) ) {
            http_response_code(401);
            exit('Unauthorized');
        }

        if ($this->attribute->role != '' && 
            !in_array(
                $this->attribute->role, 
                $_SESSION['roles']
                ) ?? []) {
            http_response_code(403);
            exit('Forbidden');
        }

        $next->handle(...func_get_args());
    }
}