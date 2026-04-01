<?
spl_autoload_register(function ($class_name) {
    $regexp = '/^(.*)\\\\(.*)$/';

    if (!preg_match($regexp, $class_name, $matches)) return;

    $base_path = '.' . DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR;
    $path = $base_path . lcfirst($matches[1]);
    $name = strtolower($matches[2]) . '.php';

    $full_name = $path . DIRECTORY_SEPARATOR . $name;

    if (file_exists($full_name)) {
        require_once $full_name;
    }
});

Core\Router::route();
