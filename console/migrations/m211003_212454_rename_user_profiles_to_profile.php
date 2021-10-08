<?php

use yii\db\Migration;

/**
 * Class m211003_212454_rename_user_profiles_to_profile
 */
class m211003_212454_rename_user_profiles_to_profile extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%user}}', 'profiles_id', 'profile_id');
    }

    public function down()
    {
        $this->renameColumn('{{%user}}', 'profile_id', 'profiles_id');
        echo "m211003_152943_rename_user_profiles_to_profile cannot be reverted.\n";
        return false;
    }
}
