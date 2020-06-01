<?php

use yii\db\Migration;

/**
 * Class m180424_005201_admin
 */
class m180424_005201_admin extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->init_data();
    }

    public function down()
    {
        $this->dropTable('{{%admin}}');
    }

    private function init_data(){
        if(class_exists("\\common\\models\\admin\\SignupForm")){
            $admin = new \common\models\admin\SignupForm();
            $admin->username = "admin";
            $admin->password = "123456";
            $admin->email = "admin@yii.com";
            $admin->signup();
        }

        if(class_exists("\\common\\models\\user\\SignupForm")){
            $user = new \common\models\user\SignupForm();
            $user->username = "user";
            $user->password = "123456";
            $user->email = "user@yii.com";
            $user->signup();
        }
    }
}
