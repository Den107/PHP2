<?php

namespace app\interfaces;

interface RecordInterface
{
    public static function getAll();


    public static function getById(int $id);


    public function delete(int $id);


    public static function getTableName(): string;
}
