<?php

namespace app\service;

use Yii;
use Exception;
use yii\db\Connection;

class DbManager
{    
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
    
    public static function getDbConnection($dbname = NULL) {
        if ($dbname === NULL) {
            $dbname = static::getCurrentDbName();
        }
        return new Connection([
            'dsn' => static::getDsnBy($dbname),
            'username' => Yii::$app->user->identity->username,
            'password' => '',
        ]);
    }
    
    public static function refreshAvailableDbNames() {
        $availableDbNames = [];
        if (!Yii::$app->user->isGuest) {
            foreach (static::$DB_NAMES as $dbname) {
                $connection = static::getDbConnection($dbname);
                try {
                    $connection->open();
                    $availableDbNames[] = $dbname;
                    $connection->close();
                } catch (Exception $exp) {
                }
            }
            Yii::$app->session[self::AVAILABLE_DB_NAMES_SESSION_KEY] = $availableDbNames;
        }
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
    
    public static function getTableNames($dbname = null) {
        $tables = [];
        if ($dbname === NULL) {
            $dbname = static::getCurrentDbName();
        }
        if (!empty($dbname)) {
            $tables = static::queryAll(static::createAndOpenConnection($dbname), 'SHOW TABLES', NULL, []);
            if (!empty($tables)) {
                foreach ($tables as $index => $row) {
                    $tables[$index] = array_values($row)[0];
                }
            }
        }
        return $tables;
    }
    
    public static function getTableNamesAndCaptions($dbname = null) {
        $tables = [];
        if ($dbname === NULL) {
            $dbname = static::getCurrentDbName();
        }
        if (!empty($dbname)) {
            $tables = static::queryAll(static::createAndOpenConnection($dbname),
                    "SELECT TABLE_NAME, TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = :dbname",
                    [':dbname' => $dbname], []);
            if (!empty($tables)) {
                foreach ($tables as $index => $row) {
                    $values = array_values($row);
                    $name = $values[0];
                    $caption = '';
                    if (!empty(trim($values[1]))) {
                        $params = json_decode($values[1], true);
                        if (isset($params['caption'])) {
                            $caption = $params['caption'];
                        }
                    }
                    $tables[$index] = ['name' => $name, 'caption' => $caption];
                }
            }
        }
        return $tables;
    }
    
    protected static function createAndOpenConnection($dbname) {
        $connection = static::getDbConnection($dbname);
        $connection->open();
        return $connection;
    }
    
    protected static function queryAll($connection, $query, $params = NULL, $default = NULL) {
        $result = $default;
        $transaction = $connection->beginTransaction();
        try {
            $command = $connection->createCommand($query);
            if (!empty($params)) {
                $command = $command->bindValues($params);
            }
            $result = $command->queryAll();
            $transaction->commit();
            $connection->close();
        } catch (Exception $exp) {
            $transaction->rollBack();
            throw $exp;
        }
        return $result;
    }
}
