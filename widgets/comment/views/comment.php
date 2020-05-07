<?php
/* @var $this View */
/* @var $comments */
/* @var $commentForm */
/* @var $idToRecord */

use app\widgets\Alert;
use yii\web\View;
use yii\widgets\ActiveForm;
?>

<?php if(!empty($comments)): ?>
    <?php foreach ($comments as $comment): ?>
        <div class="bottom-comment">
            <div class="comment-img">
                <img width="60" class="img-circle" src="<?= $comment->user->getImage() ?>" alt="">
            </div>

            <div class="comment-text">
                <h5><?= $comment->user->name ?></h5>

                <p class="comment-date">
                    <?= $comment->getDate(); ?>
                </p>


                <p class="para"> <?= $comment->text ?> </p>
            </div>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

<?php if (!Yii::$app->user->isGuest): ?>
    <div class="leave-comment">
        <h4>Leave a reply</h4>
        <?= Alert::widget() ?>
        <?php
        $form = ActiveForm::begin([
            'action' => ['site/comment', 'articleId' => $idToRecord],
            'options' => ['class' => 'form-horizontal contact-form', 'role' => 'form']
        ])
        ?>
        <div class="form-group">
            <div class="col-md-12">
                <?= $form->field($commentForm, 'comment')->textarea(['class' => 'form-control', 'placeholder' => 'Write message', 'rows' => '6'])->label(false) ?>
            </div>
        </div>
        <button type="submit" class="btn send-btn">Post Comment</button>
        <?php ActiveForm::end() ?>
    </div>
<?php else: ?>
    <h4>You need login to post comment</h4>
<?php endif; ?>
