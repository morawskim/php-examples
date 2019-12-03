<?php

namespace App\models;

use App\ConnectionManager;
use yii\mongodb\ActiveRecord;

/**
 * @property $data mixed
 */
class ItemMongoDb extends ActiveRecord
{
    public static function collectionName()
    {
        return 'items';
    }

    public static function getDb()
    {
        return ConnectionManager::getInstance()->mongodbConnection;
    }

    public function attributes()
    {
        return ['_id', 'data'];
    }
}
