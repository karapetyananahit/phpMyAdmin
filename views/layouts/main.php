<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\web\JqueryAsset;
JqueryAsset::register($this);

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
$this->registerCssFile('@web/css/db.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]);
$this->registerJsFile('@web/js/db-sidebar.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/db-create.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/db-content.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<main id="main" class="flex-shrink-0" role="main">
    <div class="d-flex">
        <div class="sidebar-fixed">
            <?= \app\components\SidebarWidget::widget() ?>
        </div>

        <div class="content-with-sidebar flex-grow-1">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
