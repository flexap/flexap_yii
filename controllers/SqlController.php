<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\service\DbManager;

class SqlController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['shell', 'run'],
                'rules' => [
                    [
                        'actions' => ['shell', 'run'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays SQL shell.
     *
     * @return string
     */
    public function actionShell()
    {
        return $this->render('shell');
    }
    
    /**
     * Run SQL script and return result.
     *
     * @return string
     */
    public function actionRun()
    {
        $script = Yii::$app->request->post('script');
        $output = '';
        if (!empty($script)) {
            $params = Yii::$app->request->post('params');
            $useFile = Yii::$app->request->post('usefile') === 'true' ? true: false;
            $username = Yii::$app->user->identity->username;
            $dbname = DbManager::getCurrentDbName();
            $command = "mysql -u $username";
            
            if (!$useFile) {
                $script = str_replace("'", "\\'", $script);
                $script = str_replace('"', '\"', $script);
                $command .= " -e '$script'";
            }
            $command .= " $params $dbname";
            
            if ($useFile) {
                $scriptPath = tempnam(sys_get_temp_dir(), 'script');
                $handle = fopen($scriptPath, 'w');
                fwrite($handle, $script);
                fclose($handle);
                
                $command .= " < $scriptPath";
            }

            exec($command . ' 2>&1', $output);
            $output = implode("\n", $output) . "\n\n";
            
            if ($useFile) {
                unlink($scriptPath);
            }
        }
        return json_encode(['out' => htmlspecialchars($output)], JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Select db.
     * 
     * @param string $dbname
     */
    public function actionDb($dbname = null)
    {
        DbManager::refreshAvailableDbNames();
        if (!empty($dbname) && in_array($dbname, DbManager::getAvailableDbNames())) {
            DbManager::setNewDbName($dbname);
        }
        return $this->redirect(strtok(Yii::$app->request->referrer, '?'));
    }
    
}
