<?
namespace Core;

class FormValidation
{
    private array $rules = [];
    private array $errors = [];

    public function isNotEmpty(mixed $data): ?string
    {
        if ($data === null) {
            return 'Field must be filled';
        }

        if (is_string($data) && trim($data) === '') {
            return 'Field must be filled';
        }

        return null;
    }

    public function isWordCount(mixed $data, int $value): ?string
    {
        if (!is_scalar($data)) {
            return 'Value must be scalar';
        }

        $data = trim((string)$data);

        $word_count = str_word_count($data);

        if ($word_count === $value) {
            return "Field must have count of words equal {$value} (has {$word_count})";
        }

        return null;
    }

    public function isWordCountLessOrEqual(mixed $data, int $value): ?string
    {
        if (!is_scalar($data)) {
            return 'Value must be scalar';
        }

        $data = trim((string)$data);

        $word_count = str_word_count($data);

        if ($word_count > $value) {
            return "Field must have count of words less or equal {$value} (has {$word_count})";
        }

        return null;
    }

    public function isWordCountGreaterOrEqual(mixed $data, int $value): ?string
    {
        if (!is_scalar($data)) {
            return 'Value must be scalar';
        }

        $data = trim((string)$data);

        $word_count = str_word_count($data);

        if ($word_count < $value) {
            return "Field must have count of words greater or equal {$value} (has {$word_count})";
        }

        return null;
    }

    public function isInteger(mixed $data): ?string
    {
        if (!is_scalar($data)) {
            return 'Value must be scalar';
        }

        $data = trim((string)$data);

        if (!preg_match('/^-?\d+$/', $data)) {
            return 'Value must be integer';
        }

        return null;
    }

    public function isLess(mixed $data, int $value): ?string
    {
        $integer_error = $this->isInteger($data);

        if ($integer_error !== null) {
            return $integer_error;
        }

        if ((int)$data < $value) {
            return "Value must be less than {$value}";
        }

        return null;
    }

    public function isGreater(mixed $data, int $value): ?string
    {
        $integer_error = $this->isInteger($data);

        if ($integer_error !== null) {
            return $integer_error;
        }

        if ((int)$data > $value) {
            return "Value must be greater than {$value}";
        }

        return null;
    }

    public function isEmail(mixed $data): ?string
    {
        if (!is_scalar($data)) {
            return 'Value must be scalar';
        }

        $data = trim((string)$data);

        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return 'Value must be valid email';
        }

        return null;
    }

    public function isNumber(mixed $data): ?string
    {
        if (!is_scalar($data)) {
            return 'Value must be scalar';
        }

        $data = trim((string)$data);

        if (!preg_match('/^(?:\+7|3\d{8,10})$/', $data)) {
            return 'Value must be a telephone number';
        }

        return null;
    }

    public function SetRule(string $field_name, string $validator_name, mixed $param = null): void
    {
        $this->rules[$field_name][] = [
            'validator' => $validator_name,
            'param' => $param
        ];
    }

    public function Validate(array $form): bool
    {
        $this->errors = [];

        foreach ($this->rules as $field_name => $field_rules) {
            $data = $form[$field_name] ?? null;

            foreach ($field_rules as $rule) {
                $validator = $rule['validator'];
                $param = $rule['param'];

                if (!method_exists($this, $validator)) {
                    $this->errors[] = "Unknown validator {$validator} for field {$field_name}";
                    continue;
                }

                $error = null;

                if ($param === null) {
                    $error = $this->$validator($data);
                } else {
                    $error = $this->$validator($data, $param);
                }

                if ($error !== null) {
                    $this->errors[] = "Field \"{$field_name}\": {$error}";
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function ShowErrors(): string
    {
        if (empty($this->errors)) {
            return '<div class="styles">Нет ошибок</div>';
        }

        $html = '<ul class="styles">';

        foreach ($this->errors as $error) {
            $html .= '<li>' . htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</li>';
        }

        $html .= '</ul>';

        return $html;
    }
}