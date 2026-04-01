<?
namespace Core;

class View
{
    function render($content_view, $model = NULL, $layout = 'layout.php')
    {
        include 'app/views/'.$layout;
    }
}
