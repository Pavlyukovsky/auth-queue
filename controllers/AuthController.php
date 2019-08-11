<?php

namespace app\controllers;

use app\helpers\FilterResponseDataHelper;
use app\models\LoginForm;
use app\models\RegistrationForm;

class AuthController extends BaseController
{
    public function verbs()
    {
        return [
            'registration' => ['post'],
            'login' => ['post'],
            'logout' => ['post'],
        ];
    }

    /**
     * Registration user.
     *
     * @return \yii\web\Response
     * @throws \app\exceptions\ValidationHttpException
     */
    public function actionRegistration()
    {
        $data = \Yii::$app->request->post();

        $registrationForm = new RegistrationForm();
        $registrationForm->firstName = $data['firstname'] ?? null;
        $registrationForm->lastName = $data['lastname'] ?? null;
        $registrationForm->nickName = $data['nickname'] ?? null;
        $registrationForm->age = $data['age'] ?? null;
        $registrationForm->password = $data['password'] ?? null;

        if (!$registrationForm->validate()) {
            $errors = $registrationForm->getFirstErrors();
            $this->throwError(sprintf('Not valid data. %s', array_shift($errors)));
        }

        $user = null;
        try {
            $user = $registrationForm->register();

            \Yii::$app->user->login($user);
        } catch (\Exception $exception) {
            $this->throwError($exception->getMessage(), $exception->getCode());
        }

        FilterResponseDataHelper::filterUser($user);

        return $this->asJson(['status' => 200, 'entity' => $user]);
    }

    /**
     * Login user.
     *
     * @return \yii\web\Response
     * @throws \app\exceptions\ValidationHttpException
     */
    public function actionLogin()
    {
        $data = \Yii::$app->request->post();

        $loginForm = new LoginForm();
        $loginForm->nickName = $data['nickname'] ?? null;
        $loginForm->password = $data['password'] ?? null;

        if (!$loginForm->validate() || !$loginForm->login()) {
            $errors = $loginForm->getFirstErrors();
            $this->throwError(sprintf('Not valid data. %s', array_shift($errors)));
        }

        return $this->asJson(['status' => 200]);
    }

    /**
     * Logout user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->asJson(['status' => 200]);
    }

}
