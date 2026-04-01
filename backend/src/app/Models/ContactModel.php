<?
namespace Models;

use \Core\Model;

class ContactModel extends Model {
    public function __construct()
    {
        parent::__construct();

        $this->validator->setRule('FIO', 'isWordCountGreaterOrEqual', 2);
        $this->validator->setRule('FIO', 'isWordCountLessOrEqual', 3);

        $this->validator->setRule('gender', 'isNotEmpty');
        
        $this->validator->setRule('age', 'isNotEmpty');

        $this->validator->setRule('email', 'isEmail');

        $this->validator->setRule('number', 'isNumber');

        $this->validator->setRule('birthday', 'isNotEmpty');
    }
}