<?php

use yii\db\Migration;

/**
 * Class m200506_165216_add_needed_column_to_registration
 */
class m200506_165216_add_needed_column_to_registration extends Migration
{
    private $tableName = 'user';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'password');
        $this->addColumn($this->tableName, 'auth_key', $this->string(32)->notNull());
        $this->addColumn($this->tableName, 'password_hash', $this->string()->notNull());
        $this->addColumn($this->tableName, 'password_reset_token', $this->string()->unique());
        $this->addColumn($this->tableName, 'status', $this->smallInteger()->notNull()->defaultValue(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn($this->tableName, 'password', $this->string());
        $this->dropColumn($this->tableName, 'auth_key');
        $this->dropColumn($this->tableName, 'password_hash');
        $this->dropColumn($this->tableName, 'password_reset_token');
        $this->dropColumn($this->tableName, 'status');
    }
}
