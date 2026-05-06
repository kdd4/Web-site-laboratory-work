<?php
namespace Models;

use \Core\ActiveRecordModel;
use DateInterval;
use DateTime;

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

    public function getRoles() : array {
        return explode(',', $this->roles ?? '');
    }

    public function getPayload(): array {
        $now = new DateTime();
        $livetime = new DateInterval('P2D');

        $exp = new DateTime();
        $exp->add($livetime);

        return [
            'sub' => $this->id,
            'iat' => $now->getTimestamp(),
            'exp' => $exp->getTimestamp()
        ];
    }
}