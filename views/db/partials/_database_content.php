<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$types = ['INT', 'VARCHAR(255)', 'TEXT', 'DATE', 'DATETIME', 'BOOLEAN'];
/** @var string $db */
/** @var array $tables */
?>
<div class="d-flex justify-content-between">
    <h3>Database: <?= Html::encode($db) ?></h3>
    <p>
        <?= Html::a('Drop Database', ['db/drop-database', 'db' => $db], [
            'class' => 'btn btn-danger drop-db-btn',
            'data-db' => $db,
        ]) ?>
    </p>
</div>

<?php if (!empty($tables)): ?>
    <table class="table table-bordered table-hover mt-3">
        <thead class="table-light">
        <tr>
            <th>Table</th>
            <th class="text-center" style="width: 220px;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tables as $table): ?>
            <tr>
                <td><?= Html::encode($table) ?></td>
                <td class="text-center">
                    <a href="<?= Url::to(['db/view-table', 'db' => $db, 'table' => $table]) ?>"
                       class="btn btn-sm btn-primary browse-link">
                        Browse
                    </a>

                    <a href="<?= Url::to(['db/structure', 'db' => $db, 'table' => $table]) ?>"
                       class="btn btn-sm btn-secondary structure-link">
                        Structure
                    </a>

                    <a href="<?= Url::to(['db/drop-table', 'db' => $db, 'table' => $table]) ?>"
                       class="btn btn-sm btn-danger"
                       data-confirm="Are you sure you want to drop the table '<?= Html::encode($table) ?>'?"
                       data-method="post">Drop</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-muted">No tables found in this database.</p>
<?php endif; ?>

<h4 class="mt-5">Create New Table</h4>

<?php $form = ActiveForm::begin([
    'action' => ['db/create-table'],
    'method' => 'post',
]); ?>

<?= Html::hiddenInput('db', $db) ?>

<div class="mb-3">
    <label>Table Name</label>
    <?= Html::textInput('table_name', '', ['class' => 'form-control', 'required' => true]) ?>
</div>

<div class="mb-3">
    <label>Columns</label>
    <div id="columns-container">
        <div class="row mb-2">
            <div class="col-md-5">
                <input type="text" name="columns[0][name]" class="form-control" placeholder="Column name" required>
            </div>
            <div class="col-md-5">
                <select name="columns[0][type]" class="form-control">
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $type ?>"><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success add-column">+</button>
            </div>
        </div>
    </div>
</div>

<?= Html::submitButton('Create Table', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>

