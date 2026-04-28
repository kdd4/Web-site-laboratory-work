<?php
namespace Models;

use \Core\ActiveRecordModel;

class BlogModel extends ActiveRecordModel {
    protected static array $fields = ['fio', 'theme', 'image', 'imgtype', 'text', 'time'];

    protected static string $tablename = 'blog';

    public function __construct()
    {
        parent::__construct();
        
        $this->validator->setRule('fio', 'isWordCountGreaterOrEqual', 2);
        $this->validator->setRule('fio', 'isWordCountLessOrEqual', 3);
        
        $this->validator->setRule('theme', 'isNotEmpty');
        $this->validator->setRule('text', 'isNotEmpty');
    }
}