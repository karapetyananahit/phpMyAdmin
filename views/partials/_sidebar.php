<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $databases */
/** @var array $tablesPerDb */
?>


<div class="sidebar-wrapper border-end pe-2 bg-white shadow-sm"
     style="width: 300px; height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto; background-color: white; z-index: 1000;">
    <div class="text-center py-3 border-bottom bg-white sticky-top" style="z-index: 1010;">
        <h5 class="mb-0">phpMyAdmin</h5>
    </div>
    <div class="d-flex justify-content-between align-items-center py-3 px-3 border-bottom bg-light sticky-top">
        <h5 class="mb-0"><i class="fas fa-database me-2"></i>Databases</h5>

        <a href="<?= Url::to(['db/create-database']) ?>" class="btn btn-sm btn-outline-success">
            <i class="fas fa-plus me-1"></i>New
        </a>

    </div>

    <ul class="list-unstyled ps-3 pe-2 pt-2">
        <?php foreach ($databases as $db): ?>
            <li class="mb-2">
                <div class="d-flex align-items-start">
                    <span class="toggle-table text-primary me-2" data-db="<?= Html::encode($db) ?>" style="cursor:pointer; font-size: 1.1rem;">
                        <i class="fas fa-angle-right"></i>
                    </span>

                    <div class="flex-grow-1">
                        <a href="<?= Url::to(['db/view-database', 'db' => $db]) ?>"
                           class="text-decoration-none fw-semibold text-dark db-link-hover">
                            <?= Html::encode($db) ?>
                        </a>
                        <ul class="list-unstyled ms-4 mt-1 table-list collapse" id="tables-<?= Html::encode($db) ?>">
                            <?php if (!empty($tablesPerDb[$db])): ?>
                                <?php foreach ($tablesPerDb[$db] as $table): ?>
                                    <li class="text-muted small" style="white-space: nowrap;">
                                        <a href="<?= Url::to(['db/view-table', 'db' => $db, 'table' => $table]) ?>"
                                           class="text-decoration-none">
                                            <?= Html::encode($table) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php
$js = <<<JS
document.querySelectorAll('.toggle-table').forEach(function(toggleBtn) {
    toggleBtn.addEventListener('click', function() {
        var db = this.getAttribute('data-db');
        var tableList = document.getElementById('tables-' + db);
        var icon = this.querySelector('i');
        var isCollapsed = tableList.classList.contains('collapse');

        if (isCollapsed) {
            tableList.classList.remove('collapse');
            icon.classList.remove('fa-angle-right');
            icon.classList.add('fa-angle-down');
        } else {
            tableList.classList.add('collapse');
            icon.classList.remove('fa-angle-down');
            icon.classList.add('fa-angle-right');
        }
    });
});
JS;

$this->registerJs($js);
?>

<style>

</style>
