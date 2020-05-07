<?php

/* @var $this View */
/* @var $article Article */
/* @var $populars Article[] */
/* @var $recents Article[] */
/* @var $comments Comment[] */
/* @var $categories Category[] */
/* @var $commentForm CommentForm */

use app\entity\Article;
use app\entity\Category;
use app\entity\Comment;
use app\form\CommentForm;
use app\widgets\comment\CommentWidget;
use app\widgets\sidebar\SidebarWidget;
use yii\helpers\Url;
use yii\web\View;

$this->title = $article->title;
?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <img src="<?= $article->getImage() ?>" alt="">
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute('site/category', ['id' => $article->category_id]) ?>"> <?= $article->category->title ?></a></h6>

                            <h1 class="entry-title"><?= $article->title ?></h1>

                        </header>
                        <div class="entry-content">
                            <?= $article->content ?>
                        </div>
                        <div class="decoration">
                            <?php foreach ($article->tags as $tag): ?>
                                <a href="<?= Url::toRoute('site/tag', ['id' => $tag->id]) ?>" class="btn btn-default"><?= $tag->title ?></a>
                            <?php endforeach; ?>
                        </div>

                        <div class="social-share">
							<span
                                class="social-share-title pull-left text-capitalize">By <?= $article->user->name ?> On <?= $article->getDate() ?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>

                <?= CommentWidget::widget([
                    'comments' => $comments,
                    'commentForm' => $commentForm,
                    'idToRecord' => $article->id
                ]);
                ?>

            </div>

            <?= SidebarWidget::widget([
                'popularPosts' => $populars,
                'recentPosts' => $recents,
                'categories' => $categories
            ]);
            ?>
        </div>
    </div>
</div>
