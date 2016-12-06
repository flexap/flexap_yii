<?php

namespace app\models\user;

use dektrium\user\models\RecoveryForm as BaseRecoveryForm;
use app\models\user\User;

/**
 * Model for collecting data on password recovery.
 */
class RecoveryForm extends BaseRecoveryForm {
    
    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = parent::rules();
        $rules[count($rules) - 1]['min'] = User::PASSWORD_MIN_LENGTH;
        return $rules;
    }

}
