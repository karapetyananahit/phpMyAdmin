<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Database';
?>

<div class="container mt-5">
    <div class="card shadow rounded-4 border-0">
        <div class="card-body p-4">
            <h3 class="mb-4 text-center"><?= Html::encode($this->title) ?></h3>

            <?php $form = ActiveForm::begin([
                'id' => 'create-db-form',
                'action' => Url::to(['db/save-database']),
                'options' => ['class' => 'needs-validation', 'novalidate' => true],
            ]); ?>

            <div class="mb-3">
                <input type="text" name="db_name" class="form-control form-control-lg" placeholder="Enter database name" required>
            </div>

            <div class="d-grid">
                <?= Html::submitButton('Create Database', ['class' => 'btn btn-success btn-lg']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <div id="db-create-result" class="mt-4"></div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#create-db-form').on('submit', function(e) {
    e.preventDefault();
    let form = $(this);
    $.post(form.attr('action'), form.serialize(), function(response) {
        let result = $('#db-create-result');
        if (response.success) {
            result.html('<div class="alert alert-success">' + response.message + '</div>');
            setTimeout(() => location.reload(), 1500);
        } else {
            result.html('<div class="alert alert-danger">' + response.message + '</div>');
        }
    });
});
JS;
$this->registerJs($js);
?>
