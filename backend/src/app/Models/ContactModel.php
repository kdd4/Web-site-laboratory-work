<?php
namespace Models;

use \Core\Model;

class ContactModel extends Model {
    protected static array $fields = ['fio', 'gender', 'age', 'email', 'number', 'birthday'];

    public function __construct()
    {
        parent::__construct();

        $this->validator->setRule('fio', 'isWordCountGreaterOrEqual', 2);
        $this->validator->setRule('fio', 'isWordCountLessOrEqual', 3);

        $this->validator->setRule('gender', 'isNotEmpty');
        
        $this->validator->setRule('age', 'isNotEmpty');

        $this->validator->setRule('email', 'isEmail');

        $this->validator->setRule('number', 'isNumber');

        $this->validator->setRule('birthday', 'isNotEmpty');
    }
}