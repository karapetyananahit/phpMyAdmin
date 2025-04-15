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

    public function actionDropTable($db, $table)
    {
        Yii::$app->db->createCommand("DROP TABLE `$db`.`$table`")->execute();

        Yii::$app->session->setFlash('success', "Table `$table` was dropped from database `$db`.");

        return $this->redirect(['db/load-tables', 'db' => $db]);
    }
    public function actionCreateTable()
    {
        $request = Yii::$app->request;

        $db = $request->post('db');
        $table = $request->post('table_name');
        $columns = $request->post('columns');

        if (!$db || !$table || empty($columns)) {
            Yii::$app->session->setFlash('error', 'Missing required information.');
            return $this->redirect(['db/load-tables', 'db' => $db]);
        }

        $columnDefs = [];
        foreach ($columns as $col) {
            $name = preg_replace('/[^a-zA-Z0-9_]/', '', $col['name']); // sanitize
            $type = strtoupper($col['type']);
            $columnDefs[] = "`$name` $type";
        }

        $sql = "CREATE TABLE `$db`.`$table` (" . implode(', ', $columnDefs) . ")";

        try {
            Yii::$app->db->createCommand($sql)->execute();
            Yii::$app->session->setFlash('success', "Table '$table' created successfully.");
        } catch (\yii\db\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['db/load-tables', 'db' => $db]);
    }
    public function actionStructure($db, $table)
    {
        $columns = Yii::$app->db->createCommand("SHOW FULL COLUMNS FROM `$db`.`$table`")->queryAll();

        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('partials/_structure', [
                'db' => $db,
                'table' => $table,
                'columns' => $columns,
            ]);
        }

        return $this->render('partials/_structure', [
            'db' => $db,
            'table' => $table,
            'columns' => $columns,
        ]);
    }
    public function actionViewTable($db, $table)
    {
        $rows = Yii::$app->db->createCommand("SELECT * FROM `$db`.`$table` LIMIT 100")->queryAll();

        return Yii::$app->request->isAjax
            ? $this->renderPartial('partials/_browse', [
                'db' => $db,
                'table' => $table,
                'rows' => $rows,
            ])
            : $this->render('partials/_browse', [
                'db' => $db,
                'table' => $table,
                'rows' => $rows,
            ]);
    }


}
