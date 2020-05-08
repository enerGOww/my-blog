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

<div class="row">
    <div class="col-md-8">

        <?php foreach ($articles as $article): ?>
            <article class="post post-list">
                <div class="row">
                    <div class="col-md-6">
                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['site/article', 'id' => $article->id]) ?>"><img src=<?= $article->getImage() ?> alt="" class="pull-left"></a>

                            <a href="<?= Url::toRoute(['site/article', 'id' => $article->id]) ?>" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center">View Post</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="post-content">
                            <header class="entry-header text-uppercase">
                                <h6><a href="<?= Url::toRoute(['site/category', 'id' => $article->category_id]) ?>"> <?= $article->category->title ?></a></h6>

                                <h1 class="entry-title"><a href="<?= Url::toRoute(['site/article', 'id' => $article->id]) ?>"><?= $article->title ?></a></h1>
                            </header>
                            <div class="entry-content">
                                <p><?= $article->description ?></p>
                            </div>
                            <div class="social-share">
                                <span class="social-share-title pull-left text-capitalize">By <?= $article->user->name ?> On <?= $article->getDate() ?></span>
                            </div>
                        </div>
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
