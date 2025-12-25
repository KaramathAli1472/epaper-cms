<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Edition extends ActiveRecord
{
    // String status constants (matching your database VARCHAR)
    const STATUS_DRAFT = 'draft';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_PRIVATE = 'private';
    const STATUS_PUBLISHED = 'published';
    
    // For backward compatibility
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    // Category constants
    const CATEGORY_GENERAL = 'general';
    const CATEGORY_BREAKING = 'breaking';
    const CATEGORY_SPECIAL = 'special';
    const CATEGORY_WEEKEND = 'weekend';
    const CATEGORY_HOLIDAY = 'holiday';

    public static function tableName()
    {
        return '{{%edition}}';
    }

    public function rules()
    {
        return [
            [['epaper_id', 'title', 'date'], 'required'],
            [['epaper_id'], 'integer'],
            [['status'], 'string', 'max' => 20],
            [['date'], 'safe'],
            [['description'], 'string'],
            [['title', 'name'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 100],
            [['alias'], 'unique'],
            [['alias'], 'match', 'pattern' => '/^[a-z0-9\-]+$/', 
                'message' => 'Alias should contain only lowercase letters, numbers and hyphens.'],
            [['category'], 'string', 'max' => 50],
            [['category'], 'default', 'value' => self::CATEGORY_GENERAL],
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_SCHEDULED, self::STATUS_PRIVATE, self::STATUS_PUBLISHED]],
            [['pdf_file', 'image_file', 'code', 'created_at', 'updated_at'], 'safe'],
            
            // Generate alias if empty
            ['alias', 'default', 'value' => function($model) {
                return $model->generateAliasFromTitle();
            }],
            
            // Set name from title if empty
            ['name', 'default', 'value' => function($model) {
                return $model->title;
            }],
            
            // Generate code if empty - FIX FOR THE ERROR
            ['code', 'default', 'value' => function($model) {
                return $model->generateUniqueCode();
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'epaper_id'   => 'Epaper',
            'title'       => 'Edition Title',
            'name'        => 'Name',
            'alias'       => 'URL Alias',
            'category'    => 'Category',
            'description' => 'Description',
            'date'        => 'Publication Date',
            'pdf_file'    => 'PDF File',
            'image_file'  => 'Image File',
            'code'        => 'Code',
            'status'      => 'Status',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }
    
    /**
     * Get category options
     * @return array
     */
    public static function getCategoryOptions()
    {
        return [
            self::CATEGORY_GENERAL => 'General Edition',
            self::CATEGORY_BREAKING => 'Breaking News',
            self::CATEGORY_SPECIAL => 'Special Edition',
            self::CATEGORY_WEEKEND => 'Weekend Edition',
            self::CATEGORY_HOLIDAY => 'Holiday Edition',
        ];
    }
    
    /**
     * Get status options
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SCHEDULED => 'Scheduled',
            self::STATUS_PRIVATE => 'Private',
            self::STATUS_PUBLISHED => 'Published',
        ];
    }
    
    /**
     * Get status text
     * @return string
     */
    public function getStatusText()
    {
        $options = self::getStatusOptions();
        return isset($options[$this->status]) ? $options[$this->status] : 'Unknown';
    }
    
    /**
     * Get status badge HTML
     * @return string
     */
    public function getStatusBadge()
    {
        $badges = [
            self::STATUS_DRAFT => '<span class="badge bg-secondary">Draft</span>',
            self::STATUS_SCHEDULED => '<span class="badge bg-warning">Scheduled</span>',
            self::STATUS_PRIVATE => '<span class="badge bg-danger">Private</span>',
            self::STATUS_PUBLISHED => '<span class="badge bg-success">Published</span>',
        ];
        return $badges[$this->status] ?? '<span class="badge bg-info">Unknown</span>';
    }
    
    /**
     * Get category label
     * @return string
     */
    public function getCategoryLabel()
    {
        $options = self::getCategoryOptions();
        return isset($options[$this->category]) ? $options[$this->category] : $this->category;
    }
    
    /**
     * Generate unique code for edition
     * @return string
     */
    public function generateUniqueCode()
    {
        // Generate a unique code using date and random string
        $date = $this->date ? date('Ymd', strtotime($this->date)) : date('Ymd');
        $random = strtoupper(substr(uniqid(), 7, 6));
        $code = 'ED-' . $date . '-' . $random;
        
        // Ensure code is unique
        $baseCode = $code;
        $counter = 1;
        while (self::find()->where(['code' => $code])->andWhere(['!=', 'id', $this->id])->exists()) {
            $code = $baseCode . '-' . $counter;
            $counter++;
        }
        
        return $code;
    }
    
    /**
     * Generate alias from title
     * @return string
     */
    public function generateAliasFromTitle()
    {
        if (empty($this->alias) && !empty($this->title)) {
            $alias = strtolower($this->title);
            $alias = preg_replace('/[^a-z0-9\s]/', '', $alias);
            $alias = preg_replace('/\s+/', '-', $alias);
            $alias = trim($alias, '-');
            
            // Ensure alias is unique
            $baseAlias = $alias;
            $counter = 1;
            while (self::find()->where(['alias' => $alias])->andWhere(['!=', 'id', $this->id])->exists()) {
                $alias = $baseAlias . '-' . $counter;
                $counter++;
            }
            
            return $alias;
        }
        return $this->alias;
    }

    public function getEpaper()
    {
        return $this->hasOne(EpaperCategory::class, ['id' => 'epaper_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        if ($insert) {
            $this->created_at = $now;
        }
        $this->updated_at = $now;
        
        // Generate code if empty (FIX FOR THE ERROR)
        if (empty($this->code)) {
            $this->code = $this->generateUniqueCode();
        }
        
        // Ensure alias is generated
        if (empty($this->alias)) {
            $this->alias = $this->generateAliasFromTitle();
        }
        
        // Ensure status is set
        if ($this->status === null) {
            $this->status = self::STATUS_DRAFT;
        }
        
        // Ensure name is set (use title if empty)
        if (empty($this->name)) {
            $this->name = $this->title;
        }

        return true;
    }
    
    /**
     * Find edition by alias
     * @param string $alias
     * @return Edition|null
     */
    public static function findByAlias($alias)
    {
        return self::findOne(['alias' => $alias]);
    }
    
    /**
     * Check if edition is published
     * @return bool
     */
    public function isPublished()
    {
        return $this->status == self::STATUS_PUBLISHED;
    }
    
    /**
     * Check if edition is draft
     * @return bool
     */
    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }
    
    /**
     * Publish this edition
     * @return bool
     */
    public function publish()
    {
        $this->status = self::STATUS_PUBLISHED;
        return $this->save();
    }
    
    /**
     * Find edition by code
     * @param string $code
     * @return Edition|null
     */
    public static function findByCode($code)
    {
        return self::findOne(['code' => $code]);
    }
}
