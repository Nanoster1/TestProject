<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m230406_070300_add_user
 */
class m230406_070300_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(User::tableName(), [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'authKey' => $this->string()->null(),
            'accessToken' => $this->string()->null(),
            'address' => $this->string()->notNull(),
            'role' => $this->string()->notNull()->defaultValue('user')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230406_070300_add_user cannot be reverted.\n";

        return false;
    }

/*
// Use up()/down() to run migration code without a transaction.
public function up()
{
}
public function down()
{
echo "m230406_070300_add_user cannot be reverted.\n";
return false;
}
*/
}