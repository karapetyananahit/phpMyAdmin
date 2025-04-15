<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var string $db */
/** @var array $tables */
?>

<h3>Database: <?= Html::encode($db) ?></h3>

<?php if (!empty($tables)): ?>
    <ul class="list-group">
        <?php foreach ($tables as $table): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="<?= Url::to(['db/view-table', 'db' => $db, 'table' => $table]) ?>">
                    <?= Html::encode($table) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="text-muted">No tables found in this database.</p>
<?php endif; ?>
