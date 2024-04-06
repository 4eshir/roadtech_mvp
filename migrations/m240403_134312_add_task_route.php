<?php

use yii\db\Migration;

/**
 * Class m240403_134312_add_task_route
 */
class m240403_134312_add_task_route extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_route}}', [
            'id' => $this->primaryKey(),
            'route_id' => $this->integer(),
            'task_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fbk-task_route-1',
            'task_route',
            'route_id',
            'route',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-task_route-2',
            'task_route',
            'task_id',
            'task',
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
        $this->dropForeignKey('fbk-task_route-1', 'task_route');
        $this->dropForeignKey('fbk-task_route-2', 'task_route');

        $this->dropTable('task_route');

        return true;
    }
}
