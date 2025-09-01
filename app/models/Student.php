<?php
require_once __DIR__ . '/../src/Database.php';


class Student
{
    public static function all(): array
    {
        $sql = 'SELECT s.*, c.name AS class_name FROM students s JOIN classes c ON s.class_id=c.id ORDER BY s.id DESC';
        return Database::conn()->query($sql)->fetchAll();
    }

    public static function getClasses()
    {
        $db = new Database(); // Assuming Database class handles connection
        $stmt = $db->conn()->prepare("SELECT id, name FROM classes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::conn()->prepare('SELECT s.*, c.name AS class_name FROM students s JOIN classes c ON s.class_id=c.id WHERE s.id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }


    public static function create(array $data): array
    {
        // Uniqueness checks
        $pdo = Database::conn();
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM students WHERE reg_no=? OR email=?');
        $stmt->execute([$data['reg_no'], $data['email']]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception('reg_no or email already exists');
        }


        $stmt = $pdo->prepare('INSERT INTO students (reg_no, first_name, last_name, email, class_id, fee_status) VALUES (?,?,?,?,?,?)');
        $stmt->execute([
            $data['reg_no'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['class_id'],
            $data['fee_status'] ?? 'unpaid'
        ]);
        $id = (int)$pdo->lastInsertId();
        return self::find($id);
    }

    public static function updateById(int $id, array $data): ?array
    {
        $pdo = Database::conn();
        // Optional uniqueness checks when changing reg_no/email
        if (isset($data['reg_no'])) {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM students WHERE reg_no=? AND id<>?');
            $stmt->execute([$data['reg_no'], $id]);
            if ($stmt->fetchColumn() > 0) throw new Exception('reg_no already exists');
        }
        if (isset($data['email'])) {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM students WHERE email=? AND id<>?');
            $stmt->execute([$data['email'], $id]);
            if ($stmt->fetchColumn() > 0) throw new Exception('email already exists');
        }


        $fields = [];
        $params = [];
        foreach (['reg_no', 'first_name', 'last_name', 'email', 'class_id', 'fee_status'] as $f) {
            if (array_key_exists($f, $data)) {
                $fields[] = "$f=?";
                $params[] = $data[$f];
            }
        }
        if (!$fields) return self::find($id);
        $params[] = $id;
        $sql = 'UPDATE students SET ' . implode(',', $fields) . ' WHERE id=?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return self::find($id);
    }


    public static function deleteById(int $id): bool
    {
        $stmt = Database::conn()->prepare('DELETE FROM students WHERE id=?');
        return $stmt->execute([$id]);
    }


    public static function setFeeStatus(int $id, string $status): ?array
    {
        if (!in_array($status, ['paid', 'unpaid'], true)) throw new Exception('Invalid fee status');
        $stmt = Database::conn()->prepare('UPDATE students SET fee_status=? WHERE id=?');
        $stmt->execute([$status, $id]);
        return self::find($id);
    }


    public static function searchByName(string $term): array
    {
        $like = '%' . $term . '%';
        $sql = 'SELECT s.*, c.name AS class_name FROM students s JOIN classes c ON s.class_id=c.id
        WHERE s.first_name LIKE ? OR s.last_name LIKE ? ORDER BY s.id DESC';
        $stmt = Database::conn()->prepare($sql);
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll();
    }


    public static function classes(): array
    {
        return Database::conn()->query('SELECT * FROM classes ORDER BY name ASC')->fetchAll();
    }

    public static function findByRegNo($reg_no) {
        $db = new Database();
        $stmt = $db->conn()->prepare("SELECT * FROM students WHERE reg_no = ?");
        $stmt->execute([$reg_no]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByEmail($email) {
        $db = new Database();
        $stmt = $db->conn()->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
