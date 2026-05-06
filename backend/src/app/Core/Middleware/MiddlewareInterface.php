<?php
namespace Core\Middleware;

interface MiddlewareInterface {
    public function handle(array $next, array $params): void;
}