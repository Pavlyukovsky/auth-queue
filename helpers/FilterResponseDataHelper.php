<?php

namespace app\helpers;

use app\models\User;

class FilterResponseDataHelper
{
    /**
     * @param User $user
     */
    public static function filterUser(User $user)
    {
        unset($user->password);
    }
}