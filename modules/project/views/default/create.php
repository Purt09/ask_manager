<?php

use yii\helpers\Html;
use app\modules\project\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */

$this->title = Module::t('module', 'CREATE_PROJECT');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PROJECTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>