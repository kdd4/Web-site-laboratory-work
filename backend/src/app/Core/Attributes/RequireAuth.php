<?php
namespace Core\Attributes;

use \Attribute;
use \Core\Middleware\MiddlewareRequireAuth;

#[Attribute(Attribute::TARGET_METHOD)]
class RequireAuth {
    public function __construct(public string $role = '') {

    }

    public $middleware = MiddlewareRequireAuth::class;
}