<?php

namespace app\service;

use Yii;
use Exception;
use yii\db\Connection;

class DbManager {
    
    public static $DB_NAMES = [
        'work',
        'flexap'
    ];
    const CURRENT_DB_NAME_SESSION_KEY = 'database';
    const AVAILABLE_DB_NAMES_SESSION_KEY = 'dbnames';
    
    public static function getDsnBy($dbname) {
        return 'mysql:host=localhost;dbname=' . $dbname;
    }
    
    public static function getDefaultDbName() {
        return static::$DB_NAMES[0];
    }
    
    public static function refreshAvailableDbNames() {
        $availableDbNames = [];
        foreach (static::$DB_NAMES as $dbname) {
            $connection = new Connection([
                'dsn' => static::getDsnBy($dbname),
                'username' => Yii::$app->user->identity->username,
                'password' => '',
            ]);
            try {
                $connection->open();
                $availableDbNames[$dbname] = $dbname;
                $connection->close();
            } catch (Exception $exp) {
            }
        }
        Yii::$app->session[self::AVAILABLE_DB_NAMES_SESSION_KEY] = $availableDbNames;
        return $availableDbNames;
    }
    
    public static function getAvailableDbNames() {
        $session = Yii::$app->session;
        if (!$session->has(self::AVAILABLE_DB_NAMES_SESSION_KEY)) {
            static::refreshAvailableDbNames();
        }
        return $session[self::AVAILABLE_DB_NAMES_SESSION_KEY];
    }
    
    public static function getCurrentDbName() {
        $session = Yii::$app->session;
        if (!$session->has(self::CURRENT_DB_NAME_SESSION_KEY)) {
            $dbnames = static::getAvailableDbNames();
            if (count($dbnames) <= 0) {
                return '';
            }
            $session[self::CURRENT_DB_NAME_SESSION_KEY] = $dbnames[0];
        }
        return $session[self::CURRENT_DB_NAME_SESSION_KEY];
    }
    
    public static function setNewDbName($dbname) {
        $session = Yii::$app->session;
        $session[self::CURRENT_DB_NAME_SESSION_KEY] = $dbname;
    }
    
}
