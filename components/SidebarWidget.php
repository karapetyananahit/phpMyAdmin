<?php

namespace app\components;

use Yii;
use yii\base\Widget;


class SidebarWidget extends Widget
{
    public function run()
    {
        $connection = Yii::$app->db;
        $databases = $connection->createCommand('SHOW DATABASES')->queryColumn();

        $tablesPerDb = [];
        foreach ($databases as $db) {
            try {
                $connection->createCommand("USE `$db`")->execute();
                $tables = $connection->createCommand("SHOW TABLES")->queryColumn();
                $tablesPerDb[$db] = $tables;
            } catch (\yii\db\Exception $e) {
                $tablesPerDb[$db] = [];
            }
        }

        return $this->render('//partials/_sidebar', ['databases' => $databases,
            'tablesPerDb' => $tablesPerDb
        ]);
    }
}

