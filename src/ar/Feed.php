<?php
declare(strict_types=1);

namespace rssBot\ar;

use yii\db\ActiveRecord;

/**
 * Class Feed
 *
 * @package rssBot\ar
 *
 * @property int id
 * @property bool processed
 * @property string hash
 */
class Feed extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%feeds}}';
    }
}
