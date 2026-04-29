<?php
namespace Core\Attributes;

use Attribute;
use Core\Middleware\MiddlewareRequireAuth;

#[Attribute(Attribute::TARGET_METHOD)]
class RequireAuth {
    public $middleware = MiddlewareRequireAuth::class;
}