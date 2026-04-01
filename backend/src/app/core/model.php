<?
namespace Core;

class Model
{
    public $validator;

    public function __construct()
    {
        $this->validator = new FormValidation();
    }
    
    public function validate($form)
    {
        return $this->validator->validate($form);
    }
}