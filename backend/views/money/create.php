<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Money */

$this->title = Yii::t('app', 'Create Money');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Moneys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
