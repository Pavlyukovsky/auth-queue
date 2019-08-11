<?php
/**
 * Created by PhpStorm.
 * User: DmytroLegion
 * Date: 11.08.2019
 * Time: 18:47
 */

namespace app\models;

class UserRepository
{
    protected $basePath = '';

    protected $fileName = 'users';

    /**
     * @var array | User[]
     */
    private $users = [];

    /**
     * Save user.
     *
     * @param User $user
     */
    public function save(User $user)
    {
        $this->saveData($user);
    }

    /**
     * Get user by nick name.
     *
     * @param string $nickName
     *
     * @return User|null
     */
    public function getUserByNickName(string $nickName): ?User
    {
        $this->users = $this->getData();

        foreach ($this->users as $user) {
            if ($user->nickName !== $nickName) {
                continue;
            }
            return $user;
        }

        return null;
    }

    /**
     * Save user. And set primary key.
     *
     * @param User $user
     *
     * @return void
     */
    protected function saveData(User $user): void
    {
        $this->users = $this->getData();

        $id = 1;
        if (!empty($this->users)) {
            $id = $this->users[array_key_last($this->users)]->{$user->getPrimaryKey()} + 1;
        }

        $user->{$user->getPrimaryKey()} = $id;

        $this->users[] = $user;

        //TODO: encapsulate `serialize` into a Hydrator(logic for hydrate data).
        file_put_contents($this->basePath . $this->fileName, serialize($this->users));
    }

    /**
     * Get all users.
     *
     * @return array|mixed
     */
    protected function getData()
    {
        if (!file_exists($this->basePath . $this->fileName)) {
            return [];
        }

        //TODO: encapsulate `unserialize` into a Hydrator(logic for hydrate data).
        return unserialize(file_get_contents($this->basePath . $this->fileName));
    }
}