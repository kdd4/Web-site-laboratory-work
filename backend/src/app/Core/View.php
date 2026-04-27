<?php
namespace Core;

class View
{
    public function render(array $arguments = [], ?string $contentView = null)
    {
        if (is_null($contentView)) {
            $acceptHeader = explode(',', $_SERVER['HTTP_ACCEPT'] ?? '');

            match(true) {
                in_array('text/plain', $acceptHeader) => $contentView = 'layout.php',
                in_array('application/json', $acceptHeader) => $contentView = 'json.php',
                default => $contentView = 'html.php'
            };
        }

        foreach ($arguments as $name => $value) {
            $$name = $value;
        }

        include 'app' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $contentView;
    }
}
