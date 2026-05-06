<?php
namespace Core\Attributes;

use \Attribute;
use Core\Middleware\MiddlewareCheckAuth;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class CheckAuth {
    public function __construct(public ?string $role = null, public ?array $forMethods = null) {

    }

    public $middleware = MiddlewareCheckAuth::class;
}