<?php

namespace app\models\records;

class Category extends Record
{
    public $id;
    public $name;

    public static function getTableName(): string
    {
        return 'categories';
    }
}
