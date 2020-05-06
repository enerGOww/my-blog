<?php

/* @var $this View */
/* @var $popularPosts Article[] */
/* @var $recentPosts Article[] */
/* @var $categories Category[]*/


use app\entity\Article;
use app\entity\Category;
use yii\web\View;

?>

<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">

        <?php if ($popularPosts !== [] ) { ?>
        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>

            <?php foreach ($popularPosts as $popular): ?>
                <div class="popular-post">


                    <a href="#" class="popular-img"><img src= <?= $popular->getImage(); ?> >

                        <div class="p-overlay"></div>
                    </a>

                    <div class="p-content">
                        <a href="#" class="text-uppercase"><?= $popular->title ?></a>
                        <span class="p-date"><?= $popular->getDate() ?></span>

                    </div>
                </div>
            <?php endforeach; ?>

        </aside>
        <?php } ?>

        <?php if ($recentPosts !== [] ) { ?>
        <aside class="widget pos-padding">
            <h3 class="widget-title text-uppercase text-center">Recent Posts</h3>

            <?php foreach ($recentPosts as $recent): ?>
                <div class="thumb-latest-posts">
                    <div class="media">
                        <div class="media-left">
                            <a href="#" class="popular-img"><img src= <?= $recent->getImage() ?> >
                                <div class="p-overlay"></div>
                            </a>
                        </div>
                        <div class="p-content">
                            <a href="#" class="text-uppercase"> <?= $recent->title ?> </a>
                            <span class="p-date"> <?= $recent->getDate() ?> </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </aside>
        <?php } ?>

        <?php if ($categories !== [] ) { ?>
        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Categories</h3>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="#"> <?= $category->title ?> </a>
                        <span class="post-count pull-right"> (<?= $category->getArticles()->count() ?>) </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <?php } ?>
    </div>
</div>

