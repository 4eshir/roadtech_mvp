<?php

use yii\db\Migration;

/**
 * Class m240403_180558_add_task_route_user
 */
class m240403_180558_add_task_route_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_route_user}}', [
            'id' => $this->primaryKey(),
            'task_route_id' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->smallInteger()->comment('1 - взята пользователем, 2 - выполнена, 3 - не выполнена'),
        ]);

        $this->addForeignKey(
            'fbk-task_route_user-1',
            'task_route_user',
            'task_route_id',
            'task_route',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-task_route_user-2',
            'task_route_user',
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
        $this->dropForeignKey('fbk-task_route_user-1', 'task_route_user');
        $this->dropForeignKey('fbk-task_route_user-2', 'task_route_user');

        $this->dropTable('task_route_user');

        return true;
    }
}
