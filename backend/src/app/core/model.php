<?php
namespace Core;

class Model extends ActiveRecord
{
    public $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = new FormValidation();
    }
    
    public function validate($form)
    {
        return $this->validator->validate($form);
    }
}