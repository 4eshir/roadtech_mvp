<?php

use yii\db\Migration;

/**
 * Class m240402_105908_base_tables
 */
class m240402_105908_base_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(128)->notNull(),
            'russpass_balance' => $this->integer()->defaultValue(0),
            'money_balance' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger()->comment('10 - обычный, 20 - привилегии 1 уровня, 30 - привилегии 2 уровня'),
        ]);

        $this->createTable('{{%achievement}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->string(1024)->null(),
        ]);

        $this->createTable('{{%user_achievement}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'achievement_id' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->createTable('{{%route}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'level' => $this->smallInteger()->comment('1 - низкий, 2 - средний, 3 - сложный'),
            'distance' => $this->float(),
            'type' => $this->integer()->comment('10 - туристический, 20 - семейный с детьми, 30 - Кому слегка за 20, 40 - романтическая прогулка'),
            'created_user_id' => $this->integer()->null(),
            'likes' => $this->integer(),
        ]);

        $this->createTable('{{%user_route}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'route_id' => $this->integer(),
            'status' => $this->smallInteger()->comment('1 - добавлен в план, 2 - в процессе прохождения, 3 - завершен успешно, 4 - завершен по желанию пользователя'),
        ]);

        $this->createTable('{{%route_point}}', [
            'id' => $this->primaryKey(),
            'route_id' => $this->integer(),
            'step' => $this->integer(),
            'address' => $this->string(256),
            'geo_x' => $this->float(),
            'geo_y' => $this->float(),
            'type' => $this->integer()->comment('10 - Еда, 20 - Жилье, 30 - Достопримечательность, 40 - Интересные точки'),
        ]);

        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(128),
            'reward_type' => $this->smallInteger()->comment('1 - бонусы RUSSPASS, 2 - реальные деньги, 3 - виртуальное достижение'),
            'reward_amount' => $this->integer(),
        ]);

        $this->createTable('{{%task_achievement}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'achievement_id' => $this->integer(),
        ]);

        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string(256),
            'to_route_id' => $this->integer(),
            'to_comment_id' => $this->integer(),
        ]);

        //--FOREIGN KEYS--

        $this->addForeignKey(
            'fbk-user_achievement-1',
            'user_achievement',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-user_achievement-2',
            'user_achievement',
            'achievement_id',
            'achievement',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-route-1',
            'route',
            'created_user_id',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-user_route-1',
            'user_route',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-user_route-2',
            'user_route',
            'route_id',
            'route',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-route_point-1',
            'route_point',
            'route_id',
            'route',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-task_achievement-1',
            'task_achievement',
            'task_id',
            'task',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-task_achievement-2',
            'task_achievement',
            'achievement_id',
            'achievement',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-comment-1',
            'comment',
            'to_route_id',
            'route',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fbk-comment-2',
            'comment',
            'to_comment_id',
            'comment',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        //----------------
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fbk-user_achievement-1', 'user_achievement');
        $this->dropForeignKey('fbk-user_achievement-2', 'user_achievement');

        $this->dropForeignKey('fbk-route-1', 'route');

        $this->dropForeignKey('fbk-user_route-1', 'user_route');
        $this->dropForeignKey('fbk-user_route-2', 'user_route');

        $this->dropForeignKey('fbk-route_point-1', 'route_point');

        $this->dropForeignKey('fbk-task_achievement-1', 'task_achievement');
        $this->dropForeignKey('fbk-task_achievement-2', 'task_achievement');

        $this->dropForeignKey('fbk-comment-1', 'comment');
        $this->dropForeignKey('fbk-comment-2', 'comment');


        $this->dropTable('user_achievement');
        $this->dropTable('achievement');
        $this->dropTable('user_route');
        $this->dropTable('route_point');
        $this->dropTable('route');
        $this->dropTable('user');
        $this->dropTable('task_achievement');
        $this->dropTable('task');
        $this->dropTable('comment');

        return true;
    }
}
