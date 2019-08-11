<?php

namespace app\jobs;

use SocialTech\StorageInterface;
use yii\base\BaseObject;
use yii\di\Instance;
use yii\queue\JobInterface;

class SendAnalytics extends BaseObject implements JobInterface
{
    public $userId;
    public $sourceLabel;
    public $createdDate;

    public function execute($queue)
    {
        $data = [
            'id' => \Yii::$app->security->generateRandomString(),
            'userId' => $this->userId,
            'sourceLabel' => $this->sourceLabel,
            'createdDate' => $this->createdDate,
        ];

        /** @var StorageInterface $storage */
        $storage = Instance::ensure(StorageInterface::class);
        $storage->append('analytics.txt', json_encode($data));
    }
}