<?php
namespace Core\Middleware;

use ReflectionMethod;

class MiddlewareAction implements MiddlewareInterface {
    public function __construct(private object $controller, private string $action) {

    }

    public function handle(array $next = [], array $params=[]): void {
        $method = new ReflectionMethod($this->controller, $this->action);

        $methodParameters = array_map(fn($p) => $p->getName(), $method->getParameters());

        $filteredParams = array_filter(
            $params, 
            fn($v, $k) => in_array($k, $methodParameters), 
            ARRAY_FILTER_USE_BOTH
            );
        
        $this->controller->{$this->action}(...$filteredParams);
    }
}