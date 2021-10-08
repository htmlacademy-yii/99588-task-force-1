<?php

use yii\db\Migration;

/**
 * Class m211003_204244_create_table_user_category
 */
class m211003_204244_create_table_user_category extends Migration
{
    public function up()
    {
        $this->createTable('user_category', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            'idx-user_category-user_id',
            'user_category',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_category-user_id',
            'user_category',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_category-category_id',
            'user_category',
            'category_id'
        );

        $this->addForeignKey(
            'fk-user_category-category_id',
            'user_category',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropIndex(
            'idx-user_category-user_id',
            'user_category'
        );

        $this->dropForeignKey(
            'fk-user_category-user_id',
            'user_category'
        );

        $this->dropIndex(
            'idx-user_category-category_id',
            'user_category'
        );

        $this->dropForeignKey(
            'fk-user_category-category_id',
            'user_category'
        );

        $this->dropTable('user_category');
        echo "m211003_204244_create_table_user_category cannot be reverted.\n";
        return false;
    }
}
