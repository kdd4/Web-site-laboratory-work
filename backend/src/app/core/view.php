<?php
namespace Core;

class View
{
    public function render($contentView  = 'layout.php', $arguments = [])
    {
        foreach ($arguments as $name => $value) {
            $$name = $value;
        }

        include 'app' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $contentView;
    }
}
