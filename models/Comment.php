<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $to_route_id
 * @property int|null $to_comment_id
 *
 * @property Comment[] $comments
 * @property Comment $toComment
 * @property Route $toRoute
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['to_route_id', 'to_comment_id'], 'integer'],
            [['text'], 'string', 'max' => 256],
            [['to_route_id'], 'exist', 'skipOnError' => true, 'targetClass' => Route::class, 'targetAttribute' => ['to_route_id' => 'id']],
            [['to_comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::class, 'targetAttribute' => ['to_comment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'to_route_id' => 'To Route ID',
            'to_comment_id' => 'To Comment ID',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['to_comment_id' => 'id']);
    }

    /**
     * Gets query for [[ToComment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToComment()
    {
        return $this->hasOne(Comment::class, ['id' => 'to_comment_id']);
    }

    /**
     * Gets query for [[ToRoute]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToRoute()
    {
        return $this->hasOne(Route::class, ['id' => 'to_route_id']);
    }
}
