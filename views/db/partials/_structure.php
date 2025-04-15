<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var string $db */
/** @var string $table */
/** @var array $columns */
?>

<h4>Structure of table: <strong><?= Html::encode($table) ?></strong></h4>

<table class="table table-bordered table-striped mt-3">
    <thead class="table-light">
    <tr>
        <th>Field</th>
        <th>Type</th>
        <th>Null</th>
        <th>Key</th>
        <th>Default</th>
        <th class="text-center">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($columns as $column): ?>
        <tr>
            <td><?= Html::encode($column['Field']) ?></td>
            <td><?= Html::encode($column['Type']) ?></td>
            <td><?= Html::encode($column['Null']) ?></td>
            <td><?= Html::encode($column['Key']) ?></td>
            <td><?= Html::encode($column['Default']) ?></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning disabled">Edit</a>
                <a href="<?= Url::to(['db/drop-column', 'db' => $db, 'table' => $table, 'column' => $column['Field']]) ?>"
                   class="btn btn-sm btn-danger"
                   data-method="post"
                   data-confirm="Are you sure you want to drop the column '<?= Html::encode($column['Field']) ?>'?">
                    Drop
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
