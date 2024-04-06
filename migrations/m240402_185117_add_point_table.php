<?php

use yii\db\Migration;

/**
 * Class m240402_185117_add_point_table
 */
class m240402_185117_add_point_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%point}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
            'address' => $this->string(256),
            'geo_x' => $this->double(),
            'geo_y' => $this->double(),
            'type' => $this->integer()->comment('10 - Еда, 20 - Жилье, 30 - Достопримечательность, 40 - Интересные точки'),
        ]);

        $this->dropColumn('route_point', 'address');
        $this->dropColumn('route_point', 'geo_x');
        $this->dropColumn('route_point', 'geo_y');
        $this->dropColumn('route_point', 'type');

        $this->addColumn('route_point', 'point_id', $this->integer());

        $this->addForeignKey(
            'fbk-route_point-2',
            'route_point',
            'point_id',
            'point',
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
        $this->addColumn('route_point', 'address', $this->string(256));
        $this->addColumn('route_point', 'geo_x', $this->float());
        $this->addColumn('route_point', 'geo_y', $this->float());
        $this->addColumn('route_point', 'type', $this->integer()->comment('10 - Еда, 20 - Жилье, 30 - Достопримечательность, 40 - Интересные точки'));

        $this->dropForeignKey('fbk-route_point-2', 'route_point');

        $this->dropColumn('route_point', 'point_id');

        $this->dropTable('{{%point}}');

        return true;
    }
}
