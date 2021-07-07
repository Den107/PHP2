<?php

namespace app\models\records;

use app\interfaces\RecordInterface;
use app\services\Db;

abstract class Record implements RecordInterface
{

    protected $db;
    protected $tableName;

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->tableName = $this->getTableName();
    }

    protected static function getQuery(string $sql, array $params = [])
    {
        return Db::getInstance()->queryAll($sql, $params, get_called_class());
    }

    public static function getAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return static::getQuery($sql);
    }

    public static function getById(int $id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return static::getQuery($sql, [':id' => $id])[0];
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = :id";
        return $this->db->execute($sql, [':id' => $id]);
    }
    public function insert()
    {
        $tableName = static::getTableName();

        $columns = [];
        $params = [];

        foreach ($this as $key => $value) {
            if (in_array($key, ['db', 'tableName'])) {
                continue;
            }
            $params[":{$key}"] = $value;
            $columns[] = "`{$key}`";
        }

        $columns = implode(", ", $columns);
        $placeholders = implode(", ", array_keys($params));

        $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        $this->id = $this->db->getLastInsertId();
    }
    public function update()
    {
    }
}
