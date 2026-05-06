<?php
namespace Models;

use \Exception;
use \Core\Model;

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

    public static function getFileName(): string {
        return static::$fileName;
    }

    public static function load(?string $fileName = null): array {
        if ($fileName === null) {
            $fileName = static::$fileName;
        }

        if (!file_exists($fileName)) {
            return [];
        }

        $lines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            throw new Exception("Error: file $fileName is not opened");
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

    public static function loadFile(): string {
        if (!file_exists(static::$fileName)) {
            return "";
        }

        $file = file_get_contents(static::$fileName);

        if ($file === false) {
            throw new Exception('Error: file ' . static::$fileName . ' is not opened');
        }

        return $file;
    }

    public static function findLineByFields(array $data): ?int {
        $lines = static::load();

        $key = array_find_key($lines,
            fn($line) => array_all($data,
                fn($value, $key) => $line[$key] === $value
            )
        );

        return $key;
    }

    public function save(?string $fileName = null): void {
        if ($fileName === null) {
            $fileName = static::$fileName;
        }

        $encodeFeedback = urlencode($this->feedback);
        $data = "$this->date;$this->fio;$this->email;$encodeFeedback";

        $key = static::findLineByFields([
            'date'  => $this->date,
            'fio'   => $this->fio,
            'email' => $this->email,
        ]);
        
        if ($key !== null) {
            $lines = file($fileName, FILE_IGNORE_NEW_LINES);

            if (!$lines) {
                throw new Exception("Error: file $fileName is not opened");
            }

            $lines[$key] = $data;

            file_put_contents($fileName, implode("\n", $lines) . "\n");
            return;
        }

        $file = fopen($fileName, 'a');

        if (!$file) {
            throw new Exception("Error: file $fileName is not opened");
        }

        fwrite($file, "$data\n");

        fclose($file);
    }
}