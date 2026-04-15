<?php
namespace Core;

use \Exception;

class Model
{
    public $validator;

    protected static array $fields = [];
    protected array $data = [];

    public function __construct()
    {
        $this->validator = new FormValidation();
    }

    public function __set(string $name, mixed $value): void {
        if (!in_array($name, static::$fields))
            throw new Exception("Field $name not found");

        $this->data[$name] = $value;
    }

    public function __get(string $name): mixed {
        if (!in_array($name, static::$fields))
            throw new Exception("Field $name not found");

        return $this->data[$name] ?? null;
    }
    
    public function validate($form)
    {
        return $this->validator->validate($form);
    }
}