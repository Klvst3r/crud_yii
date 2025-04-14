<?php

use yii\db\Migration;

class m250414_064709_create_tabla_libro extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250414_064709_create_tabla_libro cannot be reverted.\n";

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('libro', [
            'id' => $this->primaryKey(),
            'titulo' => $this->string()->notNull(),
            'imagen' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable('libro');
    }
    
    
}
