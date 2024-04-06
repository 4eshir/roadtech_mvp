<?php


namespace app\models\forms;


use app\models\User;

class UserProfileForm
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}