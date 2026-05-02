<?php
namespace Models;

use Core\ActiveRecordModel;

class AuthModel extends ActiveRecordModel {
    protected static array $fields = ['login', 'password', 'roles'];

    protected static string $tablename = 'user';

    public function __construct()
    {
        parent::__construct();
        
        $this->validator->setRule('login', 'isLengthGreaterOrEqual', 3);
        
        $this->validator->setRule('password', 'isLengthGreaterOrEqual', 8);
    }

    public function alreadyExists(): bool {
        $model = static::findByFields([
            'login' => $this->login
        ]);

        return $model !== null;
    }
}