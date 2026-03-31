<?
class PageController extends Core\Controller {
    function __construct()
    {
        parent::__construct();
    }

    function index() {
        phpinfo();
    }
}