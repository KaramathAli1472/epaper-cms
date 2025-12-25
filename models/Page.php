<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Edition;
use app\models\PageCategory;
use app\models\PageArea;

class Page extends ActiveRecord
{
    // if DB doesn't have `status`, this public property prevents UnknownProperty errors
    public $status = 1;

    // store content when DB column missing
    private $_content;

    // store alias when DB column missing
    private $_alias;

    public static function tableName()
    {
        return 'page';
    }

    public function rules()
    {
        return [
            [['edition_id', 'page_no', 'image'], 'required'],
            [['edition_id', 'page_no', 'category_id'], 'integer'],
            [['title', 'image', 'thumb_url'], 'string', 'max' => 255],
            [['file_size'], 'string', 'max' => 50],
            // ensure status is integer and has a default
            ['status', 'integer'],
            ['status', 'default', 'value' => 1],
            // alias field support
            ['alias', 'string', 'max' => 255],
            ['alias', 'default', 'value' => null],
            // allow content input
            ['content', 'string'],
            ['content', 'default', 'value' => null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'edition_id'  => 'Edition',
            'page_no'     => 'Page Number',
            'title'       => 'Title',
            'image'       => 'Image',
            'thumb_url'   => 'Thumbnail',
            'category_id' => 'Category',
            'file_size'   => 'File Size',
            'status' => 'Status',
            'alias' => 'Alias',
            'content' => 'Content',
        ];
    }

    // --- alias virtual property (reads DB column if present, falls back to internal or title) ---
    public function getAlias()
    {
        if ($this->hasAttribute('alias')) {
            $val = $this->getAttribute('alias');
            if ($val !== null && $val !== '') return $val;
        }
        if ($this->hasAttribute('slug')) {
            $val = $this->getAttribute('slug');
            if ($val !== null && $val !== '') return $val;
        }
        return $this->_alias ?: $this->getAttribute('title');
    }

    public function setAlias($value)
    {
        if ($this->hasAttribute('alias')) {
            $this->setAttribute('alias', $value);
        } else {
            $this->_alias = $value;
        }
    }
    // --- end alias property ---

    // Auto-generate alias from title when empty
    public function beforeValidate()
    {
        if ((($this->hasAttribute('alias') && ($this->getAttribute('alias') === null || $this->getAttribute('alias') === ''))
            || (!$this->hasAttribute('alias') && empty($this->_alias)))
            && !empty($this->title)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $this->title), '-'));
            if ($this->hasAttribute('alias')) {
                $this->setAttribute('alias', $slug);
            } else {
                $this->_alias = $slug;
            }
        }

        return parent::beforeValidate();
    }

    public function getEdition()
    {
        return $this->hasOne(Edition::class, ['id' => 'edition_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(PageCategory::class, ['id' => 'category_id']);
    }

    // areas relation (page_area table)
    public function getAreas()
    {
        return $this->hasMany(PageArea::class, ['page_id' => 'id']);
    }

    // next page helper (Create Area Maps me use ho sakta hai)
    public function getNextPageId()
    {
        $next = self::find()
            ->where(['edition_id' => $this->edition_id])
            ->andWhere(['>', 'page_no', $this->page_no])
            ->orderBy(['page_no' => SORT_ASC])
            ->one();

        return $next ? $next->id : null;
    }

    // --- virtual content property (maps to DB column 'content' or 'body' if present) ---
    public function getContent()
    {
        // prefer actual DB columns if available
        if ($this->hasAttribute('content')) {
            return $this->getAttribute('content');
        }
        if ($this->hasAttribute('body')) {
            return $this->getAttribute('body');
        }
        return $this->_content;
    }

    public function setContent($value)
    {
        if ($this->hasAttribute('content')) {
            $this->setAttribute('content', $value);
        } elseif ($this->hasAttribute('body')) {
            $this->setAttribute('body', $value);
        } else {
            $this->_content = $value;
        }
    }
    // --- end virtual content property ---
}
