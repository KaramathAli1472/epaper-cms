<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\base\InvalidConfigException;

/**
 * @property string $title Alias for 'name' DB column
 */
class FeaturedCategory extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%featured_category}}';
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
        // Attach TimestampBehavior only if DB columns exist to avoid UnknownProperty errors.
        try {
            $schema = static::getTableSchema();
            if ($schema && isset($schema->columns['created_at']) && isset($schema->columns['updated_at'])) {
                return [
                    TimestampBehavior::class,
                ];
            }
        } catch (InvalidConfigException $e) {
            // table missing or misconfigured — skip attaching behavior
        }

        return [];
    }

    // title alias so $model->title works (maps to DB 'name')
    public function getTitle()
    {
        return $this->getAttribute('name');
    }

    public function setTitle($value)
    {
        $this->setAttribute('name', $value);
    }
}
