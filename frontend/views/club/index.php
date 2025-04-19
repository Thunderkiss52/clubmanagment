<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use frontend\models\Club;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ClubSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="club-index">

    <p>
        <?= Html::a('Create Club', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true],
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Enter name...']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($searchModel, 'is_archived')->checkbox(['label' => 'Show Archived']) ?>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'address:ntext',
            'created_at',
            [
                'class' => ActionColumn::class, // Заменили ActionColumn::className()
                'urlCreator' => function ($action, Club $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>