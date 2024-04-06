<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "route_comment".
 *
 * @property int $id
 * @property int|null $route_id
 * @property int|null $user_id
 * @property string|null $text
 * @property int|null $status 1 - активный, 2 - на модерации, 3 - скрытый
 * @property int|null $answer_to
 *
 * @property RouteComment $answerTo
 * @property Route $route
 * @property RouteComment[] $routeComments
 */
class RouteComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route_id', 'status', 'answer_to', 'user_id'], 'integer'],
            [['text'], 'string', 'max' => 256],
            [['route_id'], 'exist', 'skipOnError' => true, 'targetClass' => Route::class, 'targetAttribute' => ['route_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['answer_to'], 'exist', 'skipOnError' => true, 'targetClass' => RouteComment::class, 'targetAttribute' => ['answer_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route_id' => 'Route ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'status' => 'Status',
            'answer_to' => 'Answer To',
        ];
    }

    /**
     * Gets query for [[AnswerTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerTo()
    {
        return $this->hasOne(RouteComment::class, ['id' => 'answer_to']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Route]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoute()
    {
        return $this->hasOne(Route::class, ['id' => 'route_id']);
    }

    /**
     * Gets query for [[RouteComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRouteComments()
    {
        return $this->hasMany(RouteComment::class, ['answer_to' => 'id']);
    }
}
