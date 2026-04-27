<?php
namespace Models;

use \Core\ActiveRecordModel;

class TestModel extends ActiveRecordModel {
    protected static array $fields = ['fio', 'question1', 'question2', 'question3', 'result', 'date'];

    protected static string $tablename = 'mathtest';

    public function __construct()
    {
        parent::__construct();
        
        $this->validator->setRule('question1', 'isLess', 2.8);
        $this->validator->setRule('question1', 'isGreaterOrEqual', 2.7);

        $this->validator->setRule('question2', 'isEqual', 'r2 sin tetta');
        
        $this->validator->setRule('question3', 'isEqual', 'var1');
    }
}