<?php

use yii\db\Migration;

class m251224_051205_add_alias_and_category_to_edition_table extends Migration
{
    public function safeUp()
    {
        $table = $this->db->schema->getTableSchema('{{%edition}}');
        
        // Only add alias if it doesn't exist
        if (!isset($table->columns['alias'])) {
            $this->addColumn('{{%edition}}', 'alias', $this->string(100)->notNull()->after('title'));
        }
        
        // Only add category if it doesn't exist  
        if (!isset($table->columns['category'])) {
            $this->addColumn('{{%edition}}', 'category', $this->string(50)->defaultValue('general')->after('alias'));
        }
        
        // Try to create indexes (they might already exist)
        try {
            $this->createIndex('idx-edition-alias', '{{%edition}}', 'alias', true);
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            $this->createIndex('idx-edition-category', '{{%edition}}', 'category');
        } catch (\Exception $e) {
            // Index already exists
        }
        
        // Update existing records
        $this->execute("UPDATE {{%edition}} SET alias = CONCAT('edition-', id) WHERE alias IS NULL OR alias = ''");
        $this->execute("UPDATE {{%edition}} SET category = 'general' WHERE category IS NULL OR category = ''");
    }

    public function safeDown()
    {
        $this->dropIndex('idx-edition-alias', '{{%edition}}');
        $this->dropIndex('idx-edition-category', '{{%edition}}');
        $this->dropColumn('{{%edition}}', 'category');
        $this->dropColumn('{{%edition}}', 'alias');
    }
}
