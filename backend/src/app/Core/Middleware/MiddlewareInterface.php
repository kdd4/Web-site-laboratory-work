<?php
namespace Core\Middleware;

interface MiddlewareInterface {
    public function handle(?MiddlewareInterface $next): void;
}