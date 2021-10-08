<?php

use yii\db\Migration;

/**
 * Class m211006_153542_add_column_user_visit_at
 */
class m211006_153542_add_column_user_visit_at extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'visit_at', $this->datetime());
    }

    public function down()
    {
        $this->dropColumn('user', 'visit_at');
        echo "m211006_153542_add_column_user_visit_at cannot be reverted.\n";
        return false;
    }
}
