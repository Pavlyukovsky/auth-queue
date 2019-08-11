<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $firstName;
    public $lastName;
    public $nickName;
    public $age;
    public $password;

    protected $primaryKey = 'id';

    /**
     * Get primary key.
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement getAuthKey() method.
    }
}
