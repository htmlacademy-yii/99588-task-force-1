<?php

use yii\db\Migration;

/**
 * Class m211009_195826_add_column_profile_image_url
 */
class m211009_195826_add_column_profile_image_url extends Migration
{
    public function up()
    {
        $this->addColumn('profile', 'image_url', $this->char(128));
    }

    public function down()
    {
        $this->dropColumn('profile', 'image_url');
    }
}
