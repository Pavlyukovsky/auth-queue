<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\di\Instance;

/**
 * RegistrationForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Model
{
    public $firstName;
    public $lastName;
    public $nickName;
    public $age;
    public $password;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->userRepository = Instance::ensure(UserRepository::class);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'nickName', 'age', 'password'], 'required'],
            [['firstName', 'lastName', 'nickName', 'password'], 'string'],
            [['age'], 'integer'],
            [['nickName'], 'uniqueNickNameValidation'],
        ];
    }

    public function uniqueNickNameValidation($attribute, $params, $validator)
    {
        $user = $this->userRepository->getUserByNickName($this->$attribute);

        if ($user instanceof User) {
            $this->addError($attribute, 'Nick name is already used.');
        }
    }

    /**
     * Register user.
     *
     * @return User
     * @throws \yii\base\Exception
     */
    public function register()
    {
        $user = new User();
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;
        $user->nickName = $this->nickName;
        $user->age = $this->age;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);

        $this->userRepository->save($user);

        return $user;
    }
}
