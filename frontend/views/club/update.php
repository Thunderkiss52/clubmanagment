<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Club $model */

$this->title = 'Update Club: ' . $model->name;

?>
<div class="club-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
