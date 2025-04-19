<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Client $model */

$this->title = 'Update Client: ' . $model->id;

?>
<div class="client-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
