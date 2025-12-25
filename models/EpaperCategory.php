<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Inflector;

class EpaperCategory extends ActiveRecord
{
    /** @var UploadedFile */
    public $imageFile;

    public static function tableName()
    {
        return 'epaper_category';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'is_published'], 'integer'],
            [['status'], 'string', 'max' => 20],
            [['title', 'name', 'alias', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
            
            // Default values
            ['status', 'default', 'value' => 'active'],
            ['name', 'default', 'value' => function($model) {
                return $model->title;
            }],
            ['alias', 'default', 'value' => function($model) {
                return Inflector::slug($model->title);
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'title'        => 'Category Title',
            'name'         => 'Name',
            'alias'        => 'Alias',
            'description'  => 'Description',
            'parent_id'    => 'Parent Category',
            'image'        => 'Image',
            'imageFile'    => 'Image',
            'status'       => 'Status',
            'is_published' => 'Published',
        ];
    }

    /**
     * Auto slug & name
     */
    public function beforeSave($insert)
    {
        if (empty($this->alias) && !empty($this->title)) {
            $this->alias = Inflector::slug($this->title);
        }

        if (empty($this->name) && !empty($this->title)) {
            $this->name = $this->title;
        }
        
        // Set status if empty
        if (empty($this->status)) {
            $this->status = 'active';
        }

        if ($insert && $this->is_published === null) {
            $this->is_published = 0;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Image upload
     */
    public function uploadAndSaveImage()
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if ($this->imageFile) {
            $dir = \Yii::getAlias('@webroot/media/categories/');
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }

            $fileName = 'cat_' . time() . '.' . $this->imageFile->extension;
            $path = $dir . $fileName;

            if ($this->imageFile->saveAs($path)) {
                $this->image = 'media/categories/' . $fileName;
            }
        }
    }
    
    /**
     * Get status options
     */
    public static function getStatusOptions()
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'draft' => 'Draft',
            'archived' => 'Archived',
        ];
    }
    
    /**
     * Get published status options
     */
    public static function getPublishedOptions()
    {
        return [
            1 => 'Yes',
            0 => 'No',
        ];
    }
    
    /**
     * Get status label with badge
     */
    public function getStatusLabel()
    {
        $badges = [
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-danger">Inactive</span>',
            'draft' => '<span class="badge bg-secondary">Draft</span>',
            'archived' => '<span class="badge bg-warning">Archived</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-info">' . ucfirst($this->status) . '</span>';
    }
    
    /**
     * Get published label
     */
    public function getPublishedLabel()
    {
        return $this->is_published 
            ? '<span class="badge bg-success">Published</span>'
            : '<span class="badge bg-secondary">Draft</span>';
    }
    
    /**
     * Get parent category
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }
    
    /**
     * Get child categories
     */
    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }
    
    /**
     * Get editions for this category
     */
    public function getEditions()
    {
        return $this->hasMany(Edition::class, ['epaper_id' => 'id']);
    }
}
