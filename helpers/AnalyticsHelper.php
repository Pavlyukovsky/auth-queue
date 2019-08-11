<?php
/**
 * Created by PhpStorm.
 * User: DmytroLegion
 * Date: 11.08.2019
 * Time: 20:16
 */

namespace app\helpers;

use app\jobs\SendAnalytics;
use \yii\queue\amqp_interop\Queue;

class AnalyticsHelper
{
    public static function log($userId, $actionName)
    {
        /** @var Queue $queue */
        $queue = \Yii::$app->queue;
        $queue->push(new SendAnalytics([
            'userId' => $userId,
            'sourceLabel' => $actionName,
            'createdDate' => date('Y-m-d H:i:s'),
        ]));
    }
}