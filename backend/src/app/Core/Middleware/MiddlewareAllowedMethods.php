<?php
namespace Core\Middleware;

use \Core\Attributes\AllowedMethods;

use function in_array, func_get_args;

class MiddlewareAllowedMethods implements MiddlewareInterface {
    public function __construct(public AllowedMethods $attribute) {}

    public function handle(array $next, array $params): void {    
        $method = $_SERVER['REQUEST_METHOD'];

        header('Access-Control-Allow-Methods: ' . implode(', ', $this->attribute->methods));

        if (!in_array($method, $this->attribute->methods)) {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        if (isset($next[0])) {
            $current = array_shift($next);
            $current->handle($next, $params);
        }
    }
}