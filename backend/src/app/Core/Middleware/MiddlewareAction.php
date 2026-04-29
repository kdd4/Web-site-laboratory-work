<?php
namespace Core\Middleware;

class MiddlewareAction implements MiddlewareInterface {

    public function __construct(private object $controller, private string $action) {

    }

    public function handle(?MiddlewareInterface $next): void {
        $this->controller->{$this->action}();
    }
}