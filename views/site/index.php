<?php

/* @var $this View */
/* @var $pagination */
/* @var $populars Article[] */
/* @var $articles Article[] */
/* @var $recents Article[] */
/* @var $categories Category[] */

use app\entity\Article;
use app\entity\Category;
use app\widgets\sidebar\SidebarWidget;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

$this->title = 'My blog';
?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($articles as $article): ?>
                    <article class="post">
                    <div class="post-thumb">
                        <a href="<?= Url::toRoute(['site/article', 'id' => $article->id]) ?>"><img src=<?= $article->getImage() ?>></a>

                        <a href="<?= Url::toRoute(['site/article', 'id' => $article->id]) ?>" class="post-thumb-overlay text-center">
                            <div class="text-uppercase text-center">View Post</div>
                        </a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="#"> <?= $article->category->title ?></a></h6>

                            <h1 class="entry-title"><a href="<?= Url::toRoute(['site/article', 'id' => $article->id]) ?>">Home is peaceful place</a></h1>


                        </header>
                        <div class="entry-content">
                            <p>
                                <?= $article->description ?>
                            </p>

                            <div class="btn-continue-reading text-center text-uppercase">
                                <a href="<?= Url::toRoute(['site/article', 'id' => $article->id]) ?>" class="more-link">Continue Reading</a>
                            </div>
                        </div>
                        <div class="social-share">
                            <span class="social-share-title pull-left text-capitalize">By <a href="#">Rubel</a> On <?= $article->getDate() ?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li><?= (int) $article->viewed ?>
                            </ul>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>

                <?= LinkPager::widget([
                    'pagination' => $pagination
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