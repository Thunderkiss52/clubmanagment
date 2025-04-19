<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use frontend\models\Client;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
?>

<div class="client-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true],
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($searchModel, 'full_name')->textInput(['placeholder' => 'Enter full name...']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($searchModel, 'gender')->radioList([
                'male' => 'Male',
                'female' => 'Female',
            ], ['prompt' => 'Select Gender']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($searchModel, 'birth_date')->widget(DateRangePicker::class, [
                'bsVersion' => '4.x',
                'pluginOptions' => [
                    'ranges' => [
                        'Today' => ["moment().startOf('day')", "moment().endOf('day')"],
                        'Yesterday' => ["moment().subtract(1, 'days').startOf('day')", "moment().subtract(1, 'days').endOf('day')"],
                        'Last 7 Days' => ["moment().subtract(6, 'days').startOf('day')", "moment()"],
                        'Last 30 Days' => ["moment().subtract(29, 'days').startOf('day')", "moment()"],
                    ],
                    'locale' => [
                        'format' => 'YYYY-MM-DD',
                    ],
                ],
            ]) ?>
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
            'full_name',
            'gender',
            'birth_date',
            'created_at',
            [
                'attribute' => 'clubs',
                'value' => function ($model) {
                    $clubs = $model->getClubs()->select('name')->column();
                    return implode(', ', $clubs);
                },
            ],
            [
                'class' => ActionColumn::class, // Заменили ActionColumn::className()
                'urlCreator' => function ($action, Client $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>