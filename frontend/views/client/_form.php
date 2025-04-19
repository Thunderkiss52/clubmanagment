<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use frontend\models\Club;

?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->radioList([
        'male' => 'Male',
        'female' => 'Female',
    ]) ?>

    <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
        'bsVersion' => '4.x',
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'club_ids')->widget(Select2::class, [
        'bsVersion' => '4.x',
        'data' => Club::find()->where(['deleted_at' => null])->select('name')->indexBy('id')->column(),
        'options' => ['multiple' => true, 'placeholder' => 'Select clubs ...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Clubs <span class="text-danger">*</span>', ['class' => 'control-label']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>