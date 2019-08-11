<?php

return [
    'singletons' => [
        \SocialTech\StorageInterface::class => [
            'class' => \SocialTech\SlowStorage::class
        ]
    ]
];