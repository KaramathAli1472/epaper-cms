<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Page;

class PageArea extends ActiveRecord
{
    public static function tableName()
    {
        return 'page_area';
    }

    public function rules()
    {
        return [
            [['page_id', 'x', 'y', 'width', 'height'], 'required'],
            [['page_id', 'x', 'y', 'width', 'height'], 'integer'],
            [['link', 'title'], 'string', 'max' => 255],
        ];
    }

    public function getPage()
    {
        return $this->hasOne(Page::class, ['id' => 'page_id']);
    }
}
