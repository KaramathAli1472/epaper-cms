<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;
    const STATUS_DELETED = 0;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['fullname', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            [['password'], 'string', 'min' => 4],
            [['status'], 'integer'],
            [['fullname', 'email'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 15],
            [['role'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'status' => 'Status',
            'fullname' => 'Full Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /* IdentityInterface methods */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * FIXED: Supports BOTH hashed AND plain text for superadmin/admin
     */
    public function validatePassword($password)
    {
        // EMERGENCY FIX: superadmin/admin plain text BHI accept kare
        if (in_array($this->username, ['superadmin', 'admin'])) {
            if ($this->password === $password || 
                Yii::$app->security->validatePassword($password, $this->password)) {
                return true;
            }
        }
        
        // Normal users: Only hashed password
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Sets password hash before saving
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->authKey = Yii::$app->security->generateRandomString();
                $this->accessToken = Yii::$app->security->generateRandomString();
            }
            if (!empty($this->password)) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            $this->updated_at = time();
            return true;
        }
        return false;
    }

    /* CRUD methods */
    public static function getAllUsers()
    {
        return static::find()->where(['!=', 'status', self::STATUS_DELETED])->all();
    }

    public static function findUserById($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function createUser($data)
    {
        $user = new static();
        $user->username = $data['fullname'];
        $user->password = $data['password']; // Will be hashed in beforeSave()
        $user->status = $data['status'] ?? self::STATUS_ACTIVE;
        $user->fullname = $data['fullname'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        $user->role = $data['role'] ?? 'user';
        $user->created_at = time();
        
        return $user->save() ? $user->id : false;
    }

    public function updateUser($data)
    {
        $this->fullname = $data['fullname'] ?? $this->fullname;
        $this->email = $data['email'] ?? $this->email;
        $this->mobile = $data['mobile'] ?? $this->mobile;
        $this->role = $data['role'] ?? $this->role;

        if (!empty($data['password'])) {
            $this->password = $data['password']; // Will be hashed in beforeSave()
        }
        if (isset($data['status'])) {
            $this->status = (int)$data['status'];
        }

        return $this->save();
    }

    /**
     * FIXED: Super Admin + Admin role protection
     */
    public static function deleteUser($id)
{
    // PROTECT ONLY: Super Admin (ID:1) AND Admin (ID:2)
    if ($id == 1 || $id == 2) {
        return false;
    }
    
    $user = static::findOne($id);
    if (!$user || $user->status == self::STATUS_DELETED) {
        return false;
    }
    
    $user->status = self::STATUS_DELETED;
    return $user->save(false);
}

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        $statuses = [
            self::STATUS_ACTIVE => 'ACTIVE',
            self::STATUS_INACTIVE => 'INACTIVE',
            self::STATUS_DELETED => 'DELETED'
        ];
        return $statuses[$this->status] ?? 'UNKNOWN';
    }

    /**
     * Get formatted created date
     */
    public function getCreatedAtFormatted()
    {
        return date('F d, Y, g:i a', $this->created_at);
    }
}
