<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var string $db */
/** @var array $tables */

?>
<li class="mb-2">
    <div class="d-flex align-items-start">
        <span class="toggle-table text-primary me-2" data-db="<?= Html::encode($db) ?>" style="font-size: 1.1rem;">
            <i class="fas fa-angle-right"></i>
        </span>

        <div class="flex-grow-1">
            <a href="#"
               class="db-link-hover db-toggle text-decoration-none"
               data-db="<?= Html::encode($db) ?>"
               data-url="<?= Url::to(['db/load-tables', 'db' => $db]) ?>">
                <?= Html::encode($db) ?>
            </a>

            <ul class="list-unstyled ms-4 mt-1 table-list collapse" id="tables-<?= Html::encode($db) ?>"></ul>
        </div>
    </div>
</li>
