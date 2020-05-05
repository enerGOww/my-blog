<?php

use app\entity\Article;
use app\entity\Tag;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $article Article */
/* @var $selectedTags Tag[] */
/* @var $tags Tag[] */
/* @var $form ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::dropDownList(
        'tags',
        $selectedTags,
        $tags,
        ['class' => 'form-control', 'multiple' => true])
    ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

