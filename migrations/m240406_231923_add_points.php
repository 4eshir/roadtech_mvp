<?php

use yii\db\Migration;

/**
 * Class m240406_231923_add_points
 */
class m240406_231923_add_points extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('point', ['name', 'address', 'geo_x', 'geo_y', 'type'], [
            ['Астраханский театр оперы и балета', 'ул. Анри Барбюса, 16', '46.359455', '48.044329', '30'],
            ['Братский сад', 'ул. Тредиаковского, 1', '46.349852', '48.035907', '40'],
            ['Астраханский кремль', 'Василия Тредиаковского, 2/1', '46.348146', '48.032429', '30'],
            ['Триумфальная арка', 'Адмиралтейская улица, 1а', '46.345101', '48.020275', '40'],
            ['Декоративная скульптура "Белуга"', 'ул. Свердлова, 63', '46.35454', '48.032385', '40'],
            ['Ресторан "Опера"', 'Свердлова, 51', '46.35431', '48.032806', '10'],
            ['Гостиничный комплекс Cosmos Astrakhan Hotel', 'улица Анри Барбюса, 29в лит А', '46.361544', '48.057461', '20'],
            ['AZIMUT Сити Отель', 'Кремлёвская, 4', '46.348325', '48.02011', '20'],
            ['Кафе "Розмарин"', 'Эспланадная, 4а', '46.351797', '48.035241', '10'],
            ['Ресторан "Хурма и мандарин"', 'Коммунистическая, 7', '46.350149', '48.041691', '10'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240406_231923_add_points cannot be reverted.\n";

        return false;
    }
}