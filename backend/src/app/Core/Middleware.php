<?php
namespace Core;

use Core\Middleware\MiddlewareAction;
use ReflectionMethod;

class Middleware {
    private array $pipeline;

    public function buildPipeline(object $controller, string $action) {
        $method = new ReflectionMethod($controller, $action);
        $attributes = $method->getAttributes();

        foreach ($attributes as $attribute) {
            $attributeObject = $attribute->newInstance();

            if (!property_exists($attributeObject, 'middleware')) {
                continue;
            }

            $middlewareClass = $attributeObject->middleware;

            $middleware = new $middlewareClass($attributeObject);
            
            $this->pipeline[] = $middleware;
        }

        $this->pipeline[] = new MiddlewareAction($controller, $action);
        $this->pipeline[] = null;
    }

    public function runPipeline() {
        $this->pipeline[0]->handle(...array_splice($this->pipeline, 1));
    }
}