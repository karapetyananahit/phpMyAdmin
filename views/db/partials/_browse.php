<?php
use yii\helpers\Html;

/** @var string $table */
?>
<h4>Browsing table: <?= Html::encode($table) ?></h4>

<?php if (!empty($rows)): ?>
    <table class="table table-bordered table-striped mt-3">
        <thead>
        <tr>
            <?php foreach (array_keys($rows[0]) as $col): ?>
                <th><?= Html::encode($col) ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <?php foreach ($row as $cell): ?>
                    <td><?= Html::encode($cell) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No rows found in the table.</p>
<?php endif; ?>
