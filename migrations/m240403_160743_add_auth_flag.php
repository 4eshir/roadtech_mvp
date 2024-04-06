<?php

use yii\db\Migration;

/**
 * Class m240403_160743_add_auth_flag
 */
class m240403_160743_add_auth_flag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'auth', $this->smallInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'auth');

        return true;
    }
}
