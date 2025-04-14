<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Database';

?>


<h3>Create New Database</h3>

<?php $form = ActiveForm::begin([
    'id' => 'create-db-form',
    'action' => Url::to(['db/save-database']),
    'options' => ['class' => 'mb-3']
]); ?>

<input type="text" name="db_name" class="form-control" placeholder="Enter database name">

<?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>

<div id="db-create-result" class="mt-2"></div>

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
            if (response.success) {
                $('#db-create-result').html('<div class="alert alert-success">' + response.message + '</div>');
                setTimeout(() => location.reload(), 1500);
            } else {
                $('#db-create-result').html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        });
    });
JS;
$this->registerJs($js);
?>
