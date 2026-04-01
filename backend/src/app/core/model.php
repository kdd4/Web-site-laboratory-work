<?
namespace Core;

class Model
{
    public $validator;

    function __construct()
    {
        $this->validator = new FormValidation();
    }
    
    function validate($form)
    {
        $this->validator->validate($form);
    }
}