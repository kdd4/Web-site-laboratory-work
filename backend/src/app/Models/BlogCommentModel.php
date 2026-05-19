<?php
namespace Models;

use \Core\ActiveRecordModel;

class BlogCommentModel extends ActiveRecordModel {
    protected static array $fields = ['userID', 'blogID', 'text', 'time'];

    protected static string $tablename = 'blog_comments';

    public function __construct()
    {
        parent::__construct();
        
        $this->validator->setRule('blogID', 'isNotEmpty');
        $this->validator->setRule('text', 'isNotEmpty');
        $this->validator->setRule('time', 'isNotEmpty');
    }
}