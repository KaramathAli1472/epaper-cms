<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string|null $file_name
 * @property string|null $file_path
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Media extends ActiveRecord
{
    /** @var \yii\web\UploadedFile */
    public $uploadFile;

    public static function tableName()
    {
        return 'media'; // apni actual media table ka naam
    }

    public function rules()
{
    return [
        [['status'], 'integer'],
        [['created_at', 'updated_at'], 'safe'],
        [['title', 'file_name', 'file_path'], 'string', 'max' => 255],
        [['uploadFile'], 'file', 'skipOnEmpty' => false,
            'extensions' => 'jpg, jpeg, png, gif, pdf, doc, docx'],
    ];
}

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'title'      => 'Title',
            'file_name'  => 'File Name',
            'file_path'  => 'File Path',
            'status'     => 'Status',
            'uploadFile' => 'File',
        ];
    }
}
