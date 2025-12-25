<?php

namespace app\models;

use yii\db\ActiveRecord;

class Slider extends ActiveRecord
{
    /**
     * Table name
     */
    public static function tableName()
    {
        // Yahan apni DB table ka naam do
        // example: 'slider', 'tbl_slider', 'cms_slider' etc.
        return 'slider';
    }

    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            [['title'], 'required'],        // title must
            [['status'], 'integer'],        // 0/1 status
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 255],  // agar image path column hai
        ];
    }

    /**
     * Attribute labels (form / grid ke headings)
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'title'      => 'Slider Title',
            'image'      => 'Image',
            'status'     => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
