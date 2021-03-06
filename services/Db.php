<?php

namespace app\services;

use app\traits\SingletonTrait;
use PDO;

class Db
{
    use SingletonTrait;

    private $config = [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'login' => 'mysql',
        'password' => 'mysql',
        'dbName' => 'learn_php_1',
        'charset' => 'utf8',
    ];

    private $connection = null;

    protected function getConnection()
    {
        if (is_null($this->connection)) {
            $this->connection = new PDO(
                $this->buildDsnString(),
                $this->config['login'],
                $this->config['password']
            );
            $this->connection->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );
        }
        return $this->connection;
    }

    protected function buildDsnString(): string
    {
        return sprintf(
            '%s:dbname=%s;host=%s;charset=%s',
            $this->config['driver'],
            $this->config['dbName'],
            $this->config['host'],
            $this->config['charset']
        );
    }


    private function query(string $sql, array $params = [])
    {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    public function queryOne(string $sql, array $params = []): array
    {
        return $this->queryAll($sql, $params)[0];
    }

    public function queryAll(string $sql, array $params = [], $className = null): array
    {
        $pdoStatement =  $this->query($sql, $params);
        if (isset($className)) {
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS, $className);
        }
        return $pdoStatement->fetchAll();
    }

    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }
    public function getLastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }
}
