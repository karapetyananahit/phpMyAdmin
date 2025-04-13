<?php


namespace app\controllers;

use Yii;
use yii\web\Controller;

class DbController extends Controller
{
    public function actionIndex()
    {
        $connection = Yii::$app->db;
        $databases = $connection->createCommand('SHOW DATABASES')->queryColumn();

        return $this->render('index', [
            'databases' => $databases,
        ]);
    }

    public function actionCreateTable($db)
    {
        $connection = Yii::$app->db;
        $connection->createCommand("USE `$db`")->execute();

        if (Yii::$app->request->isPost) {
            $tableName = Yii::$app->request->post('table_name');
            $columns = Yii::$app->request->post('columns'); // array of [name, type]

            // Կառուցում ենք SQL
            $columnsSql = [];
            foreach ($columns as $col) {
                $columnsSql[] = "`{$col['name']}` {$col['type']}";
            }

            $sql = "CREATE TABLE `$tableName` (" . implode(', ', $columnsSql) . ")";

            try {
                $connection->createCommand($sql)->execute();
                Yii::$app->session->setFlash('success', "Table `$tableName` successfully created.");
                return $this->redirect(['tables', 'db' => $db]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', "Error creating table: " . $e->getMessage());
            }
        }

        return $this->render('create-table', [
            'db' => $db,
        ]);
    }


    public function actionTables($db)
    {
        $connection = Yii::$app->db;
        $connection->createCommand("USE `$db`")->execute();

        $tables = $connection->createCommand('SHOW TABLES')->queryColumn();




        return $this->render('tables', [
            'tables' => $tables,
            'db' => $db,
        ]);
    }

    public function actionViewTable($db, $table)
    {
        $connection = Yii::$app->db;
        $connection->createCommand("USE `$db`")->execute();

        $data = $connection->createCommand("SELECT * FROM `$table` LIMIT 100")->queryAll();

        return $this->render('view-table', [
            'data' => $data,
            'db' => $db,
            'table' => $table,
        ]);
    }
}
