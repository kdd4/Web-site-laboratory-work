<?
spl_autoload_register(function ($class_name) {
    $regexp = '/^(.*)\\(.*)/$';
    
    if (!preg_match($regexp, $class_name, $matches)) return;

    $path = lcfirst($matches[1]);
    $name = lcfirst($matches[2]);

    $full_name = $path . DIRECTORY_SEPARATOR . $name;

    if (file_exists($full_name)) {
        require_once $full_name;
    }
});

$router = new Core\Router();