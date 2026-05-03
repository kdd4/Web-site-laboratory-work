<?php
namespace Models;

use Core\ActiveRecordModel;

class VisitsModel extends ActiveRecordModel {
    protected static array $fields = ['time', 'page', 'ip', 'host', 'browser'];

    protected static string $tablename = 'visits';

    public function __construct()
    {
        parent::__construct();
        
        $this->validator->setRule('page', 'isNotEmpty');
    }
}