<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\ckeditor\CKEditor;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use zxbodya\yii2\galleryManager\GalleryManager;


/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    

    <div class="row">
        <div class="col-sm-3">
        <?= $form->field($model, 'status')->textInput()->dropDownList(yii::$app->params['status']) ?>
        </div>
        <div class="col-sm-3">
        <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-sm-3">
        <?= $form->field($model, 'sort_main')->textInput([
            'maxlength' => true,
            'min' => 1,
        ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <? if (empty($model->id)) {
        echo '<div class="form-group"> Создайте элемент! После этого продолжите обновление.</div>';
    } else { ?>

        <?
            if ($model->isNewRecord) {
                echo 'Невозможно загрузить изображения для новой записи';
            } else {
                echo GalleryManager::widget(
                    [
                        'model' => $model,
                        'behaviorName' => 'galleryBehavior',
                        'apiRoute' => 'product/galleryApi'
                    ]
                );
            }
        ?>

        <?//= $form->field($model, 'description_min')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'description_min')->widget(CKEditor::className(),[
            'editorOptions' => ElFinder::ckeditorOptions(['elfinder', 'path' => 'product/'.$model->id],[
                    'rows' => 6,
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                ]),
        ])?>

        <?//= $form->field($model, 'characteristics')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'characteristics')->widget(CKEditor::className(),[
            'editorOptions' => ElFinder::ckeditorOptions(['elfinder', 'path' => 'product/'.$model->id],[
                'rows' => 4,
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            ]),
        ]) ?>


        <?//= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'description')->widget(CKEditor::className(),[
            'editorOptions' => ElFinder::ckeditorOptions(['elfinder', 'path' => 'product/'.$model->id],[
                'rows' => 6,
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
            ]),
        ]) ?>

    <? } ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
