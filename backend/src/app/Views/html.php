<?php
header('Content-Type: text/html; charset=utf-8');

function HTMLparser(mixed $data): string {
    $result = match (true) {
        $data === null => 'null',
        is_bool($data) => $data ? 'true' : 'false',
        is_resource($data) => 'resource',
        is_scalar($data) || is_object($data) => htmlspecialchars((string)$data),
        is_callable($data) => $data(),
        default => null,
    };

    if ($result !== null) {
        return $result;
    }

    if (is_array($data)) {
        $lines = array_map(
            fn($element, $key) => "<li>$key: ".HTMLparser($element).'</li>', 
            $data, 
            array_keys($data)
            );
        $result = '<ul>'.implode($lines).'</ul>';
        return $result;
    }
    
    return 'unknown';
}

echo HTMLparser($data);