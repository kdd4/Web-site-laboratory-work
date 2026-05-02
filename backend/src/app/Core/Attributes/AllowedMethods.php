<?php
namespace Core\Attributes;

use \Attribute;
use \Core\Middleware\MiddlewareAllowedMethods;

#[Attribute(Attribute::TARGET_METHOD)]
class AllowedMethods {
    public array $methods;

    public function __construct(...$methods) {
        $this->methods = array_values($methods);
    }

    public $middleware = MiddlewareAllowedMethods::class;
}