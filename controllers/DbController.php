<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class DbController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function getAllDatabases()
    {
        return Yii::$app->db->createCommand('SHOW DATABASES')->queryColumn();
    }

    public function actionLoadTables($db)
    {
        $tables = Yii::$app->db->createCommand("SHOW TABLES FROM `$db`")->queryColumn();

        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('partials/_database_content', [
                'db' => $db,
                'tables' => $tables
            ]);
        }

        return $this->render('partials/_database_content', [
            'db' => $db,
            'tables' => $tables
        ]);
    }


    public function actionCreateDatabase()
    {
        return $this->render('create-database');
    }

    public function actionSaveDatabase()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $dbName = Yii::$app->request->post('db_name');

        if (!$dbName) {
            return ['success' => false, 'message' => 'Database name is required.'];
        }

        try {
            Yii::$app->db->createCommand("CREATE DATABASE `$dbName`")->execute();
            return ['success' => true, 'message' => "Database '$dbName' created."];
        } catch (\yii\db\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
