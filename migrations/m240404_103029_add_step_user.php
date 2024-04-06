<?php

use yii\db\Migration;

/**
 * Class m240404_103029_add_step_user
 */
class m240404_103029_add_step_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%route_point_user}}', [
            'id' => $this->primaryKey(),
            'route_point_id' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->smallInteger()->comment('1 - не пройдена, 2 - пройдена, 3 - пропущена')->defaultValue(1),
        ]);

        $this->addForeignKey(
            'fbk-route_point_user-1',
            'route_point_user',
            'route_point_id',
            'route_point',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-route_point_user-2',
            'route_point_user',
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
        $this->dropForeignKey('fbk-route_point_user-1', 'route_point_user');
        $this->dropForeignKey('fbk-route_point_user-2', 'route_point_user');

        $this->dropTable('route_point_user');

        return true;
    }
}
