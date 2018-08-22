<?php

use yii\db\Migration;

/**
 * Class m180424_012504_userinfo
 */
class m180424_012504_userinfo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_info}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'nickname' => $this->string(20),
            'avatar' => $this->string(256),
            'phone' => $this->string(20),
            'FOREIGN KEY ([[user_id]]) REFERENCES ' . '{{%user}}' . ' ([[id]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable('{{%admin_info}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'nickname' => $this->string(20),
            'avatar' => $this->string(256),
            'phone' => $this->string(20),
            'FOREIGN KEY ([[user_id]]) REFERENCES ' . '{{%admin}}' . ' ([[id]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%user_info}}');
        $this->dropTable('{{%admin_info}}');
    }

    /**
     * @return bool
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    /**
     * @return bool
     */
    protected function isOracle()
    {
        return $this->db->driverName === 'oci';
    }

    /**
     * @param string $delete
     * @param string $update
     * @return string
     */
    protected function buildFkClause($delete = '', $update = '')
    {
        if ($this->isMSSQL()) {
            return '';
        }

        if ($this->isOracle()) {
            return ' ' . $delete;
        }

        return implode(' ', ['', $delete, $update]);
    }
}
