<?
namespace Core;

class View
{
    public function render($content_view, $model = NULL, $layout = 'layout.php')
    {
        include 'app/views/' . $layout;
    }
}
