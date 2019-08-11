<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\di\Instance;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $nickName;
    public $password;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var User
     */
    private $user = null;

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
            [['nickName', 'password'], 'required'],
            [['nickName', 'password'], 'string'],
            [['password'], 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params, $validator)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());

        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->user === null) {
            $this->user = $this->userRepository->getUserByNickName($this->nickName);
        }

        return $this->user;
    }
}
