<?php

/** @var yii\web\View $this */

$this->title = 'phpMyAdmin';
?>

<h1>Databases</h1>
<ul>
    <a href="<?= \yii\helpers\Url::to(['db/create-database']) ?>" style="display: inline-block; padding: 8px 12px; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">
        ➕ Create New Database
    </a>
    <?php foreach ($databases as $db): ?>
        <li><a href="<?= \yii\helpers\Url::to(['db/tables', 'db' => $db]) ?>"><?= $db ?></a></li>
    <?php endforeach; ?>
</ul>

