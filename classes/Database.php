<?php
class Database {
    private PDO $pdo;

    public function __construct($address, $dbName, $username, $password) {
        try {
            $dsn = "mysql:host=$address;dbname=$dbName;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('La connexion à la base de données a échoué.<br>Erreur : <b>' . $e->getMessage() . '</b><br>Accéder à la version hors-ligne : <a href=\'./old/\'>web.snt.nsi.xyz/old/</a>.');
        }
    }

    public function getRowById(string $table, int $id): ?array {
        $sql = "SELECT * FROM `$table` WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getRowsById(string $table, int $id): ?array {
        $sql = "SELECT * FROM `$table` WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $rows = $stmt->fetchAll();
        return $rows ?: null;
    }
    
    public function getRows(string $table): ?array {
        $sql = "SELECT * FROM `$table` WHERE 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows ?: null;
    }

    public function getRowsByCustomAttribut(string $table, string $attribut, string $value): ?array {
        $sql = "SELECT * FROM `$table` WHERE `$attribut` = :val";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['val' => $value]);
        $rows = $stmt->fetchAll();
        return $rows ?: null;
    }

    public function getRowByCustomAttribut(string $table, string $attribut, string $value): ?array {
        $sql = "SELECT * FROM `$table` WHERE `$attribut` = :val LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['val' => $value]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getRowsByCondition(string $table, array $conditions): ?array {
        $sql = "SELECT * FROM $table WHERE ";
        $whereClauses = [];
        $params = [];
        $i = 0;
        foreach ($conditions as $column => $condition) {
            $paramKey = ":param{$i}";
            $operator = strtoupper($condition[0]);
            $value = $condition[1];
            if ($operator === 'IN' && is_array($value)) {
                $inParams = [];
                foreach ($value as $j => $val) {
                    $key = "{$paramKey}_{$j}";
                    $inParams[] = $key;
                    $params[$key] = $val;
                }
                $whereClauses[] = "{$column} IN (" . implode(',', $inParams) . ")";
            } else {
                $whereClauses[] = "{$column} {$operator} {$paramKey}";
                $params[$paramKey] = $value;
            }

            $i++;
        }
        $sql .= implode(' AND ', $whereClauses);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        return $rows ?: null;
    }

    public function getRowsByUniqueSet(string $table, array $set, string $condition): ?array {
        $attributes = implode(', ', $set);
        $sql = "SELECT DISTINCT $attributes FROM $table WHERE $condition";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows ?: null;
    }

    public function updateRow(string $table, array $data, string $condition): void {
        $setParts = [];
        $params = [];
        foreach ($data as $column => $value) {
            $paramName = ':' . $column;
            $setParts[] = "`$column` = $paramName";
            $params[$paramName] = $value;
        }
        $setClause = implode(', ', $setParts);
        $sql = "UPDATE `$table` SET $setClause WHERE $condition";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function getPermissionsByGroupId(int $groupId): array {
        $sql = "SELECT permission_key FROM group_permissions WHERE group_id = :group_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['group_id' => $groupId]);
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $rows ?: [];
    }

    public function getEventsByPlayer(string $playerPseudo, int $playerGameSessionId): array {
        $sql = "SELECT * FROM game_session_players WHERE pseudo = :pseudo AND game_session_id = :game_session_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['pseudo' => $playerPseudo, 'game_session_id' => $playerGameSessionId]);
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $rows ?: [];
    }
}