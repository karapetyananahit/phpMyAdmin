<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $databases */
/** @var array $tablesPerDb — key: db name, value: array of tables */
?>

<div class="p-2">
    <a href="<?= Url::to(['db/create-database']) ?>" class="d-block text-decoration-none mb-2 fw-bold">New</a>

</div>

<ul class="list-unstyled ps-2">
    <?php foreach ($databases as $db): ?>
        <li class="mb-1">
            <span class="toggle-table text-primary" data-db="<?= Html::encode($db) ?>" style="cursor:pointer;">
                ➕
            </span>

            <a href="<?= Url::to(['db/view-database', 'db' => $db]) ?>"
               class="ms-1 text-decoration-none">
                <?= Html::encode($db) ?>
            </a>

            <ul class="list-unstyled ms-4 mt-1 table-list" id="tables-<?= Html::encode($db) ?>" style="display:none;">
                <?php if (!empty($tablesPerDb[$db])): ?>
                    <?php foreach ($tablesPerDb[$db] as $table): ?>
                        <li>
                            <a href="<?= Url::to(['db/view-table', 'db' => $db, 'table' => $table]) ?>"
                               class="text-decoration-none">
                                <?= Html::encode($table) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>

<?php
$js = <<<JS

    document.querySelectorAll('.toggle-table').forEach(function(toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            var db = this.getAttribute('data-db');
            var tableList = document.getElementById('tables-' + db);
            if (tableList.style.display === 'none') {
                tableList.style.display = 'block';
                this.textContent = '➖';
            } else {
                tableList.style.display = 'none';
                this.textContent = '➕';
            }
        });
    });
JS;
$this->registerJs($js);
?>
