<?php

use yii\db\Migration;

/**
 * Class m240406_085147_change_comment
 */
class m240406_085147_change_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('route_comment', 'user_id', $this->integer()->after('route_id'));

        $this->addForeignKey(
            'fbk-route_comment-3',
            'route_comment',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fbk-route_comment-3', 'route_comment');
        $this->dropColumn('route_comment', 'user_id');

        return true;
    }
}
