<?php

namespace app\models;

use yii\db\ActiveRecord;

class CmsPage extends ActiveRecord
{
    public static function tableName()
    {
        return 'cms_page';
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],  // ← content bhi required karo
            [['title'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'title'   => 'Page Title',
            'content' => 'Content',
            'status'  => 'Status',
        ];
    }
}
