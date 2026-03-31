<?
class Model
{
    public $validator;

    function validate($post_data)
    {
        $this->validator->validate($post_data);
    }
}