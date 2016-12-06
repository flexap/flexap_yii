<?php

namespace app\models\user;

use Yii;
use dektrium\user\models\User as DektriumUser;
use dektrium\user\helpers\Password;
use dektrium\user\models\Token;

class User extends DektriumUser {
    
    const PASSWORD_MIN_LENGTH = 4;
    
    /**
     * @return bool Whether the user is an admin or not.
     */
    public function getIsAdmin()
    {
        return parent::getIsAdmin() || Yii::$app->user->can('admin');
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['passwordLength']['min'] = self::PASSWORD_MIN_LENGTH;
        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $generatingPassword = $this->password == null;
        $this->confirmed_at = time();
        $this->password = $generatingPassword ? Password::generate(self::PASSWORD_MIN_LENGTH) : $this->password;

        $this->trigger(self::BEFORE_CREATE);

        if (!$this->save()) {
            return false;
        }

        if ($generatingPassword) {
            $this->mailer->sendWelcomeMessage($this, null, true);
        }
        $this->trigger(self::AFTER_CREATE);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = $this->module->enableConfirmation ? null : time();
        $this->password     = $this->module->enableGeneratingPassword ? Password::generate(self::PASSWORD_MIN_LENGTH) : $this->password;

        $this->trigger(self::BEFORE_REGISTER);

        if (!$this->save()) {
            return false;
        }

        if ($this->module->enableConfirmation) {
            /** @var Token $token */
            $token = Yii::createObject(['class' => Token::className(), 'type' => Token::TYPE_CONFIRMATION]);
            $token->link('user', $this);
        }

        if ($this->module->enableConfirmation || $this->module->enableGeneratingPassword) {
            $this->mailer->sendWelcomeMessage($this, isset($token) ? $token : null);
        }
        $this->trigger(self::AFTER_REGISTER);

        return true;
    }
    
}