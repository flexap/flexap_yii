<?php

namespace app\models\user;

use dektrium\user\models\LoginForm as BaseLoginForm;

/**
 * LoginForm get user's login and password, validates them and logs the user in. If user has been blocked, it adds
 * an error to login form.
 */
class LoginForm extends BaseLoginForm {

    public $rememberMe = true;

    /** @inheritdoc */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['login'] =      \Yii::t('app', 'Username or email');
        $labels['rememberMe'] = \Yii::t('user', 'Remember me next time');
        return $labels;
    }
    
}
