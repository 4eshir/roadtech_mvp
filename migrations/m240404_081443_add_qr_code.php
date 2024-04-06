<?php

use yii\db\Migration;

/**
 * Class m240404_081443_add_qr_code
 */
class m240404_081443_add_qr_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%route_point}}', 'qr_code', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%route_point}}', 'qr_code');

        return true;
    }
}
