<?php
namespace Models;

use Core\ActiveRecordModel;

class AuthModel extends ActiveRecordModel {
    protected static array $fields = ['login', 'password'];

    public function __construct()
    {
        parent::__construct();
        
        $this->validator->setRule('login', 'isLengthGreaterOrEqual', 3);
        
        $this->validator->setRule('password', 'isLengthGreaterOrEqual', 8);
    }

    // МЕНЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯЯТЬ
    public function validate(): bool {
        $model = static::findByFields([
            'login' => $this->login
        ]);

        if ($model !== null) {
            return false;
        }

        return parent::validate();
    }
}