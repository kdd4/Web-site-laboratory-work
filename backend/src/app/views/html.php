<?php
header('Content-Type: text/html; charset=utf-8');

function HTMLparser(mixed $data): string {
    if (is_scalar($data) || is_object($data)) {
        return htmlspecialchars($data);
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

    if (is_callable($data)) {
        return $data();
    }
    
    return 'unknown';
}

echo HTMLparser($data);