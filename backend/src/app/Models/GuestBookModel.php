<?php
namespace Models;

use \Core\Model;
use \Exception;

class GuestBookModel extends Model {
    protected static array $fields = ['date', 'fio', 'email', 'feedback'];

    private static string $fileName = 'messages.inc';

    public function __construct()
    {
        parent::__construct();

        $this->validator->setRule('fio', 'isWordCountGreaterOrEqual', 2);
        $this->validator->setRule('fio', 'isWordCountLessOrEqual', 3);

        $this->validator->setRule('email', 'isEmail');

        $this->validator->setRule('feedback', 'isNotEmpty');
    }

    public static function load(): array {
        if (!file_exists(static::$fileName)) {
            return [];
        }

        $lines = file(static::$fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            throw new Exception('Error: file ' . static::$fileName . ' is not opened');
        }

        return array_map(
            function ($line): array {
                $elements = explode(';', $line, 4);

                return [
                    'date'      => $elements[0] ?? '',
                    'fio'       => $elements[1] ?? '',
                    'email'     => $elements[2] ?? '',
                    'feedback'  => urldecode($elements[3] ?? ''),
                ];
            }, 
            $lines
        );
    }

    public function save(): void {
        $file = fopen(static::$fileName, 'a');

        if (!$file) {
            throw new Exception('Error: file '.static::$fileName.' is not opened');
        }

        $encodeFeedback = urlencode($this->feedback);

        fwrite($file, "$this->date;$this->fio;$this->email;$encodeFeedback\n");

        fclose($file);
    }
}