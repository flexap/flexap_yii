<?php

namespace app\models\user;

use Yii;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use app\models\user\User;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 */
class RegistrationForm extends BaseRegistrationForm {
    
    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = parent::rules();
        $rules['passwordLength']['min'] = User::PASSWORD_MIN_LENGTH;
        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);

        if (!$user->register()) {
            return false;
        }

        $message = 'Your account has been created';
        if ($this->module->enableConfirmation || $this->module->enableGeneratingPassword) {
            $message .= ' and a message with further instructions has been sent to your email';
        }
        Yii::$app->session->setFlash(
            'info',
            Yii::t('user', $message)
        );

        return true;
    }

}
