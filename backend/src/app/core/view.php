<?
namespace Core;

class View
{
    public function render($content_view  = 'layout.php', $arguments = [])
    {
        foreach ($arguments as $name => $value) {
            $$name = $value;
        }

        include 'app/Views/' . $content_view;
    }
}
