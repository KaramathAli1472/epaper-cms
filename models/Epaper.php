<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "epaper".
 *
 * @property int $id
 * @property string $title
 * @property string $edition_date
 * @property string|null $pdf_path
 * @property string|null $thumbnail
 * @property string|null $category
 * @property string|null $status
 * @property string|null $created_at
 */
class Epaper extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'epaper';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdf_path', 'thumbnail'], 'default', 'value' => null],
            [['category'], 'default', 'value' => 'daily'],
            [['status'], 'default', 'value' => 'published'],
            [['title', 'edition_date'], 'required'],
            [['edition_date', 'created_at'], 'safe'],
            [['title', 'status'], 'string', 'max' => 255],
            [['pdf_path', 'thumbnail'], 'string', 'max' => 500],
            [['category'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'edition_date' => 'Edition Date',
            'pdf_path' => 'Pdf Path',
            'thumbnail' => 'Thumbnail',
            'category' => 'Category',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

}
