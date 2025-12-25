<?php

use yii\db\Migration;

class m251225_165005_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'authKey' => $this->string(32),
            'accessToken' => $this->string(32),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'fullname' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'mobile' => $this->string(15),
            'role' => $this->string(20)->notNull()->defaultValue('user'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Super Admin (ID: 1)
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'superadmin',
            'password' => 'admin123',
            'authKey' => 'test1key',
            'accessToken' => '1-token',
            'status' => 10,
            'fullname' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'mobile' => '',
            'role' => 'superadmin',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        // Admin (ID: 2)
        $this->insert('{{%user}}', [
            'id' => 2,
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test2key',
            'accessToken' => '2-token',
            'status' => 10,
            'fullname' => 'Admin User',
            'email' => 'admin@gmail.com',
            'mobile' => '',
            'role' => 'admin',
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
