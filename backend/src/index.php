<?php
use \Core\Router;

require __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    $regexp = '/^(.*)\\\\(.*)$/';

    if (!preg_match($regexp, $class_name, $matches)) return;

    $basePath = '.' . DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR;
    $path = (string)$basePath . $matches[1];
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);

    $name = "{$matches[2]}.php";

    $fullName = $path . DIRECTORY_SEPARATOR . $name;

    if (file_exists($fullName)) {
        require_once $fullName;
    }
});

Router::route();
