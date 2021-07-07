<?php

namespace app\models\records;



class Product extends Record
{
    public $id;
    public $title;
    public $description;
    public $price;
    public $img;


    public static function getTableName(): string
    {
        return 'products';
    }
}
