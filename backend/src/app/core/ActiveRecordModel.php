<?php
namespace Core;

use PDO;
use PDOException;

class ActiveRecordModel extends Model {
    protected static PDO $pdo;

    protected static string $tablename = '';

    public function __construct() {
        parent::__construct();

        if (!static::$tablename) return;

        static::connectDatabase();
    }

    protected static function connectDatabase(): void {
        if (isset(static::$pdo)) return;

        $dsn = $_ENV['DB_DSN'] ?? "";

        try {
            static::$pdo = new PDO($dsn);
            static::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            static::getFields();
        } catch (PDOException $exception) {
            error_log("Error while connecting to database: " . $exception->getMessage());
        }
    }

    public static function getFields(): void {
        $sql = 'SELECT column_name
        FROM information_schema.columns
        WHERE table_name = :table';

        $stmt = static::$pdo->prepare($sql);

        $stmt->execute(['table' => static::$tablename]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            static::$fields[] = $row['column_name'];
        }
    }

    public static function findAll(): array {
        static::connectDatabase();

        $table = static::$tablename;
        $sql = "SELECT * FROM \"$table\"";

        $stmt = static::$pdo->query($sql);

        $objects = $stmt->fetchAll(PDO::FETCH_CLASS, static::class);

        return $objects;
    }

    public static function find(int $id): ?static {
        static::connectDatabase();

        $table = static::$tablename;
        $sql = "SELECT * FROM \"$table\" WHERE id = :id";

        $stmt = static::$pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $record = new static();

        foreach ($row as $key => $value) {
            $record->$key = $value;
        }

        return $record;
    }

    public function save(): static {
        $table = static::$tablename;
        $data = $this->data;

        if (empty($data)) return $this;

        $fieldNames = array_keys($data);

        if (is_null($this->id)) {
            $columns = implode(', ', array_map(fn($f) => "\"$f\"", $fieldNames));
            $placeholders = implode(', ', array_map(fn($f) => ":$f", $fieldNames));

            $sql = "INSERT INTO \"$table\" ($columns) VALUES ($placeholders) RETURNING id";
            $stmt = static::$pdo->prepare($sql);
            $stmt->execute($data);

            $this->id = $stmt->fetchColumn();
        } else {
            $setClauses = implode(', ', array_map(fn($f) => "\"$f\" = :$f", $fieldNames));

            $sql = "UPDATE \"$table\" SET $setClauses WHERE id = :id";
            $stmt = static::$pdo->prepare($sql);
            $stmt->execute([...$data, 'id' => $this->id]);
        }

        return $this;
    }

    public function delete(): bool {
        if (is_null($this->id)) return false;

        $table = static::$tablename;
        $sql = "DELETE FROM \"$table\" WHERE id = :id";

        $stmt = static::$pdo->prepare($sql);
        $stmt->execute(['id' => $this->id]);

        return $stmt->rowCount() > 0;
    }

}