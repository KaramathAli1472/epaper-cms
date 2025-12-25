
<?php
use yii\db\Migration;

class m251222_224811_create_epaper_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('epaper', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'edition_date' => $this->date()->notNull(),
            'pdf_path' => $this->string(500),
            'thumbnail' => $this->string(500),
            'category' => $this->string(100)->defaultValue('daily'),
            'status' => $this->string()->defaultValue('published'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('epaper');
    }
}
