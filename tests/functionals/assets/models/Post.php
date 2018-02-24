<?php

namespace bupy7\activerecord\history\tests\functionals\assets\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $type
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends ActiveRecord
{
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    const TYPE_NEWS = 10;
    const TYPE_ARTICLE = 20;

    public static function getTypes()
    {
        return [
            self::TYPE_NEWS => 'News',
            self::TYPE_ARTICLE => 'Article',
        ];
    }
}
