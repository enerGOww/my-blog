<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%status_column_for_comment}}`.
 */
class m200507_142104_drop_status_column_for_comment_table extends Migration
{
    private $tableName = 'comment';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableName, 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn($this->tableName, 'status', $this->integer());
    }
}
