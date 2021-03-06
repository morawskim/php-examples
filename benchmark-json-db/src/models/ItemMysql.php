<?php

namespace App\models;

use App\ConnectionManager;
use yii\db\ActiveRecord;

/**
 * @property $data mixed
 */
class ItemMysql extends ActiveRecord
{
    public static function tableName()
    {
        return 'items';
    }

    public static function getDb()
    {
        return ConnectionManager::getInstance()->mysqlConnection;
    }
}
