<?php

namespace app\models\forms;

use app\models\RouteComment;
use yii\base\Model;

class RouteCommentForm extends Model
{
    public $routeId;
    public $text;
    public $userId;
    public $answerTo = null;

    public function rules()
    {
        return [
            [['text'], 'string', 'max' => 255],
            [['userId', 'routeId'], 'integer'],
            ['answerTo', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'routeId' => 'Маршрут',
            'text' => 'Текст комментария',
            'userId' => 'Кто отправил',
            'answerTo' => 'Ответ на',
        ];
    }

    public function save(RouteComment $entity)
    {
        $entity->text = $this->text;
        $entity->route_id = $this->routeId;
        $entity->user_id = $this->userId;
        $entity->answer_to = $this->answerTo;
        $entity->status = 1;

        return $entity->save();
    }
}