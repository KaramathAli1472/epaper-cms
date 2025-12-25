<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\base\InvalidConfigException;

/**
 * @property string $title Alias for 'name'
 */
class EpaperFeaturedEdition extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%featured_edition}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort_order'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Title',
            'sort_order' => 'Sort Order',
        ];
    }

    public function behaviors()
    {
        try {
            $schema = static::getTableSchema();
            if ($schema && isset($schema->columns['created_at']) && isset($schema->columns['updated_at'])) {
                return [
                    TimestampBehavior::class,
                ];
            }
        } catch (InvalidConfigException $e) {
            // table missing — skip behavior
        }
        return [];
    }

    // title alias for backward compatibility
    public function getTitle()
    {
        return $this->getAttribute('name');
    }

    public function setTitle($value)
    {
        $this->setAttribute('name', $value);
    }
}
