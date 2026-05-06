<?php
namespace Core\Attributes;

use \Attribute;
use \Core\Middleware\MiddlewareRequireAuth;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class RequireAuth {
    public function __construct(public ?string $role = null, public ?array $forMethods = null) {

    }

    public $middleware = MiddlewareRequireAuth::class;
}