<?php

namespace app\models\user;

use dektrium\user\models\SettingsForm as BaseSettingsForm;
use app\models\user\User;

/**
 * SettingsForm gets user's username, email and password and changes them.
 */
class SettingsForm extends BaseSettingsForm {
    
    /** @inheritdoc */
    public function rules() {
        $rules = parent::rules();
        $rules['newPasswordLength']['min'] = User::PASSWORD_MIN_LENGTH;
        return $rules;
    }

}
