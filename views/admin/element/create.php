<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Element */

$this->title = Yii::t('element', 'Create Element');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('element', 'Elements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="element-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>