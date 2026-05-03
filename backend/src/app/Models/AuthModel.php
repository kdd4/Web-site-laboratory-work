<?php
namespace Models;

use Core\ActiveRecordModel;

class AuthModel extends ActiveRecordModel {
    protected static array $fields = ['login', 'password', 'fio', 'email', 'roles'];

    protected static string $tablename = 'user';

    public function __construct()
    {
        parent::__construct();
        
        $this->validator->setRule('login', 'isLengthGreaterOrEqual', 3);
        $this->validator->setRule('password', 'isLengthGreaterOrEqual', 8);

        $this->validator->setRule('fio', 'isWordCountGreaterOrEqual', 2);
        $this->validator->setRule('fio', 'isWordCountLessOrEqual', 3);

        $this->validator->setRule('email', 'isEmail');
    }

    public function alreadyExists(): bool {
        $model = static::findByFields([
            'login' => $this->login
        ]);

        return $model !== null;
    }
}