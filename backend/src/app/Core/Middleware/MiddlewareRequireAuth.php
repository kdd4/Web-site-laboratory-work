<?php
namespace Core\Middleware;

class MiddlewareRequireAuth implements MiddlewareInterface {
    public function handle(?MiddlewareInterface $next): void {    
        
        $next->handle(...func_get_args());
    }
}