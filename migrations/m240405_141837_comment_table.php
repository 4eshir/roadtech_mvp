<?php

use yii\db\Migration;

/**
 * Class m240405_141837_comment_table
 */
class m240405_141837_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%route_comment}}', [
            'id' => $this->primaryKey(),
            'route_id' => $this->integer(),
            'text' => $this->string(256),
            'status' => $this->smallInteger()->comment('1 - активный, 2 - на модерации, 3 - скрытый'),
            'answer_to' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fbk-route_comment-1',
            'route_comment',
            'route_id',
            'route',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-route_comment-2',
            'route_comment',
            'answer_to',
            'route_comment',
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
        $this->dropForeignKey('fbk-route_comment-1', 'route_comment');
        $this->dropForeignKey('fbk-route_comment-2', 'route_comment');

        $this->dropTable('route_comment');

        return true;
    }
}
