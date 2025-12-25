<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\base\InvalidConfigException;

/**
 * @property string $title Alias for 'name'
 */
class EpaperPageCategory extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%page_category}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort_order'], 'integer'],
            // ensure a default is provided when not submitted
            ['sort_order', 'default', 'value' => 0],
            [['name'], 'string', 'max' => 255],
        ];
    }

    // make sure even if validation is skipped sort_order isn't null
    public function beforeValidate()
    {
        if ($this->sort_order === null) {
            $this->sort_order = 0;
        }
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sort_order' => 'Sort Order',
        ];
    }

    public function behaviors()
    {
        try {
            $schema = static::getTableSchema();
            if ($schema && isset($schema->columns['created_at']) && isset($schema->columns['updated_at'])) {
                return [TimestampBehavior::class];
            }
        } catch (InvalidConfigException $e) {
            // table missing — skip behavior
        }
        return [];
    }

    // alias so views using ->title still work
    public function getTitle()
    {
        return $this->getAttribute('name');
    }

    public function setTitle($value)
    {
        $this->setAttribute('name', $value);
    }
}
