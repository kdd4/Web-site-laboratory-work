<?php
namespace Models;

use \Core\Model;

class GuestBookModel extends Model {
    public function __construct()
    {
        parent::__construct();

        $this->validator->setRule('FIO', 'isWordCountGreaterOrEqual', 2);
        $this->validator->setRule('FIO', 'isWordCountLessOrEqual', 3);

        $this->validator->setRule('email', 'isEmail');

        $this->validator->setRule('feedback', 'isNotEmpty');
    }
}